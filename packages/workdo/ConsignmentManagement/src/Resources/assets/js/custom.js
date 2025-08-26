$(document).on('click', '.moreless-button', function() {
    // Find the related elements within the same product card
    var $productCard = $(this).closest('.table-responsive');
    var $moreText = $productCard.find('.moretext');
    var $button = $(this);

    // Toggle the visibility of the text
    $moreText.toggleClass('show');

    // Update the button text based on the visibility of the more text
    if ($moreText.hasClass('show')) {
        $button.text("view less...");
    } else {
        $button.text("view more...");
    }
});
