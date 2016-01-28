jQuery(function ($) {
	// Use only one frame for all upload fields
	var frame,
		$spinner = $('#portfolio-detail .spinner');

	// Select images
	$('body').on('click', '#ta-images-upload', function (e) {
		e.preventDefault();

		var $uploadButton = $(this),
			$imageList = $uploadButton.prev('#project-images');

		// Create a frame only if needed
		if (!frame) {
			frame = wp.media({
				className: 'media-frame',
				multiple : true,
				title    : taPortfolio.frameTitle,
				library  : {
					type: 'image'
				}
			});
		}

		// Show spinner
		$spinner.show();

		// Open media uploader
		frame.open();

		// Remove all attached 'select' event
		frame.off('select');

		// Handle selection
		frame.on('select', function () {
			var ids,
				selection = frame.state().get('selection').toJSON();

			// Get only files that haven't been added to the list
			// Also prevent duplication when send ajax request
			selection = _.filter(selection, function (attachment) {
				return $imageList.children('li#item_' + attachment.id).length == 0;
			});
			ids = _.pluck(selection, 'id');

			if (ids.length > 0) {
				var data = {
					action        : 'ta_portfolio_attach_images',
					post_id       : $('#post_ID').val(),
					attachment_ids: ids,
					_ajax_nonce   : $uploadButton.data('nonce')
				};

				$.post(ajaxurl, data, function (r) {
					if (r.success) {
						$imageList.append(r.data);
						$spinner.hide();
					}
				}, 'json');
			}
		});
	});

	// Reorder images
	var $imageList = $('#project-images');
	$imageList.sortable({
		placeholder: 'ui-state-highlight',
		items      : 'li',
		update     : function () {
			var data = {
				action     : 'ta_portfolio_order_images',
				post_id    : $('#post_ID').val(),
				order      : $imageList.sortable('serialize'),
				_ajax_nonce: $imageList.data('nonce')
			};
			$.post(ajaxurl, data);
		}
	});

	// Delete image
	$imageList.on('click', '.ta-portfolio-delete-image', function (e) {
		e.preventDefault();

		var $this = $(this),
			$parent = $this.parents('li'),
			data = {
				action       : 'ta_portfolio_delete_image',
				post_id      : $('#post_ID').val(),
				attachment_id: $this.data('attachment_id'),
				_ajax_nonce  : $this.data('nonce')
			};

		$spinner.show();
		$parent.addClass('removing');

		$.post(ajaxurl, data, function (r) {
			if (r.success) {
				$parent.fadeOut(300, function () {
					$(this).remove();
					$spinner.hide();
				});
			}
		}, 'json');
	});
});
