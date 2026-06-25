<?php
/**
 * Standalone .pot generator — run from CLI:
 *   php make-pot.php
 * Writes languages/newsuperprime.pot
 * Scans all .php files in the theme for i18n function calls.
 */

$theme_dir  = __DIR__;
$output     = $theme_dir . '/languages/newsuperprime.pot';
$text_domain = 'newsuperprime';

// -----------------------------------------------------------------------
// 1. Collect all .php files (excluding this script itself)
// -----------------------------------------------------------------------
$rii   = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $theme_dir ) );
$files = [];
foreach ( $rii as $file ) {
    if ( $file->isDir() ) continue;
    $path = $file->getPathname();
    if ( substr( $path, -4 ) !== '.php' ) continue;
    if ( realpath( $path ) === realpath( __FILE__ ) ) continue;
    // skip vendor / node_modules if any
    if ( strpos( $path, DIRECTORY_SEPARATOR . 'node_modules' . DIRECTORY_SEPARATOR ) !== false ) continue;
    if ( strpos( $path, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR ) !== false ) continue;
    $files[] = $path;
}
sort( $files );

// -----------------------------------------------------------------------
// 2. Extract translatable strings
// -----------------------------------------------------------------------
// Pattern captures: func( 'string', 'domain' )  or  func( "string", "domain" )
// Handles: __, _e, esc_html__, esc_html_e, esc_attr__, esc_attr_e, _x, _ex, _n, _nx
$pattern = '/(?:__|_e|esc_html__|esc_html_e|esc_attr__|esc_attr_e|_x|_ex|_n|_nx)\s*\(\s*([\'"])((?:[^\1\\\\]|\\\\.)*?)\1\s*,\s*[\'"]' . preg_quote( $text_domain, '/' ) . '[\'"][\s,\)]/';

$strings = []; // msgid => [ [file, line], ... ]

foreach ( $files as $filepath ) {
    $content = file_get_contents( $filepath );
    $lines   = explode( "\n", $content );
    $rel     = str_replace( $theme_dir . DIRECTORY_SEPARATOR, '', $filepath );
    $rel     = str_replace( '\\', '/', $rel );

    foreach ( $lines as $lineno => $line ) {
        if ( preg_match_all( $pattern, $line, $matches, PREG_SET_ORDER ) ) {
            foreach ( $matches as $m ) {
                $raw = $m[2];
                // Unescape
                $msgid = str_replace( [ "\\'", '\\"', '\\\\', '\\n', '\\t' ], [ "'", '"', '\\', "\n", "\t" ], $raw );
                if ( $msgid === '' ) continue;
                $strings[ $msgid ][] = [ $rel, $lineno + 1 ];
            }
        }
    }
}

// -----------------------------------------------------------------------
// 3. Build .pot content
// -----------------------------------------------------------------------
$date = gmdate( 'Y-m-d\TH:i:s+00:00' );
// Build header using explicit concatenation so \n stay as literal escape sequences in the file.
$pot  = "# Copyright (C) 2024 New Super Prime\n";
$pot .= "# This file is distributed under the GNU General Public License v2.\n";
$pot .= "msgid \"\"\n";
$pot .= "msgstr \"\"\n";
$pot .= '"Project-Id-Version: New Super Prime 1.0.0\n"' . "\n";
$pot .= '"Report-Msgid-Bugs-To: https://wordpress.org/support/theme/newsuperprime\n"' . "\n";
$pot .= '"POT-Creation-Date: ' . $date . '\n"' . "\n";
$pot .= '"MIME-Version: 1.0\n"' . "\n";
$pot .= '"Content-Type: text/plain; charset=UTF-8\n"' . "\n";
$pot .= '"Content-Transfer-Encoding: 8bit\n"' . "\n";
$pot .= '"PO-Revision-Date: 2024-MO-DA HO:MI+ZONE\n"' . "\n";
$pot .= '"Last-Translator: FULL NAME <EMAIL@ADDRESS>\n"' . "\n";
$pot .= '"Language-Team: LANGUAGE <LL@li.org>\n"' . "\n";
$pot .= '"X-Generator: make-pot.php\n"' . "\n";
$pot .= '"X-Domain: newsuperprime\n"' . "\n";
$pot .= "\n";

foreach ( $strings as $msgid => $locations ) {
    foreach ( $locations as $loc ) {
        $pot .= '#: ' . $loc[0] . ':' . $loc[1] . "\n";
    }
    $escaped = addcslashes( $msgid, '"\\' );
    // Handle multiline
    if ( strpos( $escaped, '\n' ) !== false ) {
        $pot .= "msgid \"\"\n";
        foreach ( explode( '\n', $escaped ) as $i => $chunk ) {
            $nl  = ( $i < substr_count( $escaped, '\n' ) ) ? '\n' : '';
            $pot .= '"' . $chunk . $nl . '"' . "\n";
        }
    } else {
        $pot .= 'msgid "' . $escaped . '"' . "\n";
    }
    $pot .= "msgstr \"\"\n\n";
}

// -----------------------------------------------------------------------
// 4. Write file
// -----------------------------------------------------------------------
if ( ! is_dir( dirname( $output ) ) ) {
    mkdir( dirname( $output ), 0755, true );
}
file_put_contents( $output, $pot );

$count = count( $strings );
echo "Done. {$count} unique strings written to languages/newsuperprime.pot\n";
