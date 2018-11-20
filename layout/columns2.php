<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The two column layout.
 *
 * @package   theme_unitecstandard
 * @copyright 2013 Moodle, moodle.org
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Get the HTML for the settings bits.
$html = theme_unitecstandard_get_html_for_settings($OUTPUT, $PAGE);

// Set default (LTR) layout mark-up for a two column page with blocks on the left.
$topfullwidth = 'span12';
$regionmainbox = 'span12';
$upperfullwidth = 'span12';
$regionmain = 'span9 pull-right';
$sidepre = 'span3 desktop-first-column';
$lowerfullwidth = 'span12';
$bottomfullwidth = 'span12';

// Reset layout mark-up for RTL languages.
if (right_to_left()) {
    $topfullwidth = 'span12';
	$regionmainbox = 'span12 pull-right';
    $upperfullwidth = 'span12';
    $regionmain = 'span9';
    $sidepre = 'span3 pull-right';
	$lowerfullwidth = 'span12';
	$bottomfullwidth = 'span12';
}

//Checks to see if there is content to display
$hastopfullwidth = $PAGE->blocks->region_has_content('top-fullwidth', $OUTPUT);
$hasbottomfullwidth = $PAGE->blocks->region_has_content('bottom-fullwidth', $OUTPUT);
$hasupperfullwidth = $PAGE->blocks->region_has_content('upper-fullwidth', $OUTPUT);
$haslowerfullwidth = $PAGE->blocks->region_has_content('lower-fullwidth', $OUTPUT);


echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Audiowide|Bungee+Shade|Cinzel|Indie+Flower|Josefin+Sans:400i|Open+Sans|Orbitron|Permanent+Marker|Roboto+Slab|Taviraj|Trirong|Satisfy|Architects+Daughter|Dancing+Script" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner" class="navbar navbar-fixed-top<?php echo $html->navbarclass ?> moodle-has-zindex">
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
            <?php echo $OUTPUT->navbar_home(); ?>
            <?php echo $OUTPUT->navbar_button(); ?>
            <?php echo $OUTPUT->user_menu(); ?>
            <?php echo $OUTPUT->search_box(); ?>
            <div class="nav-collapse collapse">
                <?php echo $OUTPUT->custom_menu(); ?>
                <ul class="nav pull-right">
                    <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div id="page" class="container-fluid">
    <?php echo $OUTPUT->full_header(); ?>
    <div id="page-content" class="row-fluid">
        <?php
		if ($hastopfullwidth)  {
			echo $OUTPUT->blocks('top-fullwidth', $topfullwidth);
		}
		?>
        <div id="region-main-box" class="<?php echo $regionmainbox; ?>">
            <div class="row-fluid">
                <section id="region-main" class="<?php echo $regionmain; ?>">
                  <div class="row-fluid">
                   <?php
					if ($hasupperfullwidth)  {
						echo $OUTPUT->blocks('upper-fullwidth', $upperfullwidth); 
					}
					?>
					</div>
                    <?php
                    echo $OUTPUT->course_content_header();
                    echo $OUTPUT->main_content();
                    echo $OUTPUT->course_content_footer();
                    ?>
                    <div class="row-fluid">
                    <?php
                    if ($haslowerfullwidth)  {
						echo $OUTPUT->blocks('lower-fullwidth', $lowerfullwidth); 
					}
					?>
					</div>
                </section>
                <?php echo $OUTPUT->blocks('side-pre', $sidepre); ?>
            </div>
        </div>
    </div>
    <div class="row-fluid">
     <?php
	if ($hasbottomfullwidth)  {
		echo $OUTPUT->blocks('bottom-fullwidth', $bottomfullwidth); 
	}
	?>
	</div>
   </div>
    <footer id="page-footer">
        <div id="course-footer"><?php echo $OUTPUT->course_footer(); ?></div>
        <p class="helplink"><?php echo $OUTPUT->page_doc_link(); ?></p>
        <?php
        echo $html->footnote;
        echo $OUTPUT->login_info();
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </footer>

    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>