<?php

namespace SGI\STL\Utils;

use SGI\STL\Core\LanguageManager   as LM,
    SGI\Transliterator              as Transliterator;

/**
 * Returns default plugin options
 * 
 * @return array Default plugin options
 * 
 * @since 2.0
 */
function getDefaultOptions() : array
{

    return [
        'migrated'       => false,
        'core'  => [
            'script'     => 'cir',
            'cookie'     => true,
            'param'      => 'pismo',
        ],
        'file'  => [
            'names'      => true,
            'translit'   => true,
            'content'    => true,
            'delim'      => '-',
        ],
        'fixes' =>[
            'permalinks' => (get_option('WPLANG') == 'sr_RS') ? false : true, 
            'search'     => true,
        ],
        'menu'  => [
            'extend'     => true,
            'selector'   => '',
            'type'       => 'dropdown',
            'label'      => 'Писмо'
        ],
        'ml'    => [
            'wpml'       => true,
            'pll'        => true,
            'qtx'        => true
        ]
    ];

}

/**
 * Returns plugin options saved in the database. Fallbacks to sane defaults
 * 
 * @return array Plugin options
 * 
 * @since 2.0
 */
function getOptions() : array
{

    return get_option(
        'sgi/stl/opt',
        getDefaultOptions()
    );

}

function get_script()
{

    return LM::get_instance()->get_script();

}

function get_script_param()
{
    return LM::get_instance()->get_script_param();
}

function is_serbian()
{
    return LM::get_instance()->is_serbian();
}

function is_wpml_active()
{

    return LM::is_wpml_active();

}

function is_cyrillic()
{
    return (get_script() == 'cir') ? true : false;
}

function is_latin()
{

    return (get_script() == 'lat') ? true : false;

}

function get_query_param()
{
    return getOptions()['core']['param'];
}

function transliterate($content, $cut = false)
{

    return (!$cut) ? 
            Transliterator::cir_to_lat($content) :
            Transliterator::cir_to_cut_lat($content);

    return $content;

}

function reverse_transliterate($content)
{

     return Transliterator::lat_to_cir($content);
    
}

function multiscript_sql_query($search)
{

    global $wpdb;

    $search_term = $_GET['s'];

    if (preg_match('/\s/',$search_term)) :

        $search_term = rtrim($search_term);
        $search_expl = explode(' ', $search_term);

        $search = 'AND ('; $first = true;

        foreach ($search_expl as $word ) :

            if (!$first) :

                $search .= ' AND ';
                
            endif;
            $first = false;

            $lat_word = reverse_transliterate($word);

            $search .= sprintf(
                "(%s.post_title LIKE '%%%s%%' OR %s.post_title LIKE '%%%s%%' OR %s.post_content LIKE '%%%s%%' OR %s.post_content LIKE '%%%s%%')",
                $wpdb->posts,
                $word,
                $wpdb->posts,
                $lat_word,
                $wpdb->posts,
                $word,
                $wpdb->posts,
                $lat_word
            );

        endforeach;

        $search .= ')';

    else :

        $search_term = ' \'%'.$_GET['s'].'%\'';
        $lat_search_term = reverse_transliterate($search_term);

        $search = " AND ( ({$wpdb->posts}.post_title LIKE ${lat_search_term} OR {$wpdb->posts}.post_title LIKE ${search_term} OR {$wpdb->posts}.post_content LIKE ${lat_search_term} OR {$wpdb->posts}.post_content LIKE ${search_term} ) ) ";

    endif;

    //var_dump($search);

    return $search;

}