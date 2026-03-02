'use strict';

/**
 * Product URL (Slug) Auto-Generator
 * Generates URL-friendly slug from product name
 */

$(document).ready(function () {
    let isManuallyEdited = false;

    /**
     * Generate slug from string
     * Converts text to URL-friendly format
     */
    function generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }

    /**
     * Auto-generate slug on product name keyup
     */
    $(document).on('keyup', '.product-name-input', function () {
        if (!isManuallyEdited) {
            const productName = $(this).val();
            const slug = generateSlug(productName);
            $('#product_url').val(slug);
        }
    });

    /**
     * Track manual editing of product URL
     */
    $(document).on('keydown', '#product_url', function () {
        isManuallyEdited = true;
    });

    /**
     * Reset manual edit flag when product name is focused
     */
    $(document).on('focus', '.product-name-input', function () {
        // Allow auto-generation again if URL field is empty
        if ($('#product_url').val().trim() === '') {
            isManuallyEdited = false;
        }
    });

    /**
     * Format slug on blur (cleanup)
     */
    $(document).on('blur', '#product_url', function () {
        const currentValue = $(this).val();
        const cleanedSlug = generateSlug(currentValue);
        $(this).val(cleanedSlug);
    });

    /**
     * Prevent spaces in product URL field
     */
    $(document).on('keypress', '#product_url', function (e) {
        if (e.which === 32) {
            e.preventDefault();
            return false;
        }
    });
});
