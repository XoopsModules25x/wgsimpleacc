// Jquery function for order fields
// When the page is loaded define the current order and items to reorder
$(document).ready( function(){
/* script for sortable list */
	var ns = $('ol.sortable').nestedSortable({
		forcePlaceholderSize: true,
		handle: 'div',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'placeholder',
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div',
		maxLevels: 10,
		isTree: true,
		expandOnHover: 700,
		startCollapsed: false,
		excludeRoot: true,
		rootID:"0"
	});

	$('.disclose').on('click', function() {
		$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		$(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
	});

/* Call the container items to reorder fields */
  $( function() {
    $( "ol.sortable" ).nestedSortable({
			update: function(event, ui) {
				var list = $(this).nestedSortable( 'serialize');
				$.post( 'accounts.php?op=order', list );
			},
			receive: function(event, ui) {
				var list = $(this).nestedSortable( 'serialize');                    
				$.post( 'accounts.php?op=order', list );                      
			}
		});
    $( "ol.sortable" ).disableSelection();
  } );
});