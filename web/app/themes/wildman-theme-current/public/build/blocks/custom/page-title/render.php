<?php
$id         = get_the_ID();
$show_title = get_post_meta( $id, 'show_page_title', true );
//$is_new_page = get_post_status( get_the_ID() ) === 'auto-draft';

var_dump( $show_title );

if ( $show_title ) {
    $inner_cover_block = [
        'blockName'   => 'core/cover',
        'attrs'       => [
            'url'           => 'https://placehold.co/800x400/000000/FFFFFF?text=Inner+Cover',
            'dimRatio'      => 50,
            'hasParallax'   => false,
            'minHeight'     => 300,
            'minHeightUnit' => 'px',
        ],
        'innerBlocks' => [
            [
                'blockName'    => 'core/paragraph',
                'attrs'        => [],
                'innerContent' => ['<p>This is a paragraph inside the inner Cover block.</p>'],
            ],
        ],
    ];
    $outer_cover_block = [
        'blockName'   => 'core/cover',
        'attrs'       => [
            'url'           => 'https://placehold.co/1200x600/555555/EEEEEE?text=Outer+Cover',
            'dimRatio'      => 80,
            'hasParallax'   => true,
            'minHeight'     => 600,
            'minHeightUnit' => 'px',
        ],
        // The key is to add the inner block to this array.
        'innerBlocks' => [
            $inner_cover_block,
        ],
    ];
    echo render_block( $outer_cover_block );

    // --- Define the Inner Block ---
    // This is the paragraph inside the inner Cover block.
    $inner_paragraph = [
        'blockName'    => 'core/paragraph',
        'attrs'        => [
            'fontSize' => 'large',
        ],
        'innerContent' => ['<p class="has-large-font-size">Hello, this is a nested paragraph!</p>'],
    ];

    // This is the inner Cover block, which contains the paragraph.
    $inner_cover_block = [
        'blockName'    => 'core/cover',
        'attrs'        => [
            'dimRatio'  => 50,
            'minHeight' => 300,
        ],
        'innerBlocks'  => [
            $inner_paragraph,
        ],
        // innerContent needs to be defined for the inner paragraph to render.
        'innerContent' => ['<div class="wp-block-cover__inner-container"></div>'],
    ];

    // --- Define the Outer Block ---
    // This is the outer Cover block, which contains the inner Cover block.
    $outer_cover_block = [
        'blockName'    => 'core/cover',
        'attrs'        => [
            'dimRatio'    => 80,
            'hasParallax' => true,
            'minHeight'   => 600,
        ],
        // The inner block is nested here.
        'innerBlocks'  => [
            $inner_cover_block,
        ],
        'innerContent' => ['<div class="wp-block-cover__inner-container"></div>'],
    ];

    // Render the final, nested block.
    $rendered_html = render_block( $outer_cover_block );
    var_dump( $outer_cover_block );

    // This is a simple echo to show the result.
    //echo '<div style="margin: 2em; padding: 2em; border: 1px dashed #ccc;">';
    //echo '<h3>Test Nested Block Output:</h3>';
    echo $rendered_html;
    //echo '</div>';

// Let's assume you have an array containing the block data.
    $block_data = [
        'blockName'    => 'core/cover', // The name of the block
        'attrs'        => [
            "overlayColor"       => "season",
            "isUserOverlayColor" => true,
            "minHeight"          => 20,
            "minHeightUnit"      => "vh",
            "contentPosition"    => "center center",
            "isDark"             => false,
            "align"              => "full",
            "className"          => "page-title",
               //"style":["spacing":{"padding":{"top"=>"var:preset|spacing|20","bottom"=>"var:preset|spacing|20","left"=>"0","right"=>"0"}}},"layout":{"type"=>"constrained"}
        ], // Attributes for the block (e.g., alignment, colors)
        'innerContent' => [
            'XXX',
        ],
    ];

// Echo the rendered block content.
    // echo render_block( $block_data );

    //echo '<!-- wp:cover {"overlayColor":"season","isUserOverlayColor":true,"minHeight":20,"minHeightUnit":"vh","contentPosition":"center center","isDark":false,"align":"full","className":"page-title","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"0","right":"0"}}},"layout":{"type":"constrained"}} --><div class="wp-block-cover alignfull is-light page-title" style="padding-top:var(--wp--preset--spacing--20);padding-right:0;padding-bottom:var(--wp--preset--spacing--20);padding-left:0;min-height:20vh"><span aria-hidden="true" class="wp-block-cover__background has-season-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:cover {"dimRatio":0,"minHeight":30,"minHeightUnit":"vh","contentPosition":"bottom left","isDark":false,"style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} --><div class="wp-block-cover is-light has-custom-content-position is-position-bottom-left" style="padding-top:0;padding-bottom:0;min-height:30vh"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"0","right":"0"}},"dimensions":{"minHeight":"100%"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"bottom"}} --><div class="wp-block-group" style="min-height:100%;padding-top:var(--wp--preset--spacing--20);padding-right:0;padding-bottom:var(--wp--preset--spacing--20);padding-left:0"><!-- wp:post-title {"textAlign":"center","level":1} /--></div><!-- /wp:group --></div></div><!-- /wp:cover --></div></div><!-- /wp:cover -->';
//<div class="wp-block-cover alignfull is-light page-title has-season-background-color" style="padding-top:var(--wp--preset--spacing--20);padding-right:0;padding-bottom:var(--wp--preset--spacing--20);padding-left:0;min-height:20vh;display: flex;aspect-ratio:unset;flex-direction: column-reverse;"><div class="has-global-padding is-layout-constrained wp-block-cover-is-layout-constrained wp-block-cover__inner-container wp-container-core-cover-is-layout-982ec413"><div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-b1ecbeaf wp-block-group-is-layout-flex" style="min-height:100%;padding-top:var(--wp--preset--spacing--20);padding-right:0;padding-bottom:var(--wp--preset--spacing--20);padding-left:0"><h1 class="has-text-align-center wp-block-post-title">' . get_the_title() . '</h1></div></div></div>';
}
