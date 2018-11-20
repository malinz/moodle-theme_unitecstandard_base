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
 * The secure layout.
 *
 * @package   theme_unitecstandard_base
 * @copyright 2013 Moodle, moodle.org
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Get the HTML for the settings bits.
$html = theme_unitecstandard_base_get_html_for_settings($OUTPUT, $PAGE);

// Set default (LTR) layout mark-up for a three column page.
$topfullwidth = 'span12';
$regionmainbox = 'span9';
$upperfullwidth = 'span12';
$regionmain = 'span8 pull-right';
$sidepre = 'span4 desktop-first-column';
$sidepost = 'span3 pull-right';
$lowerfullwidth = 'span12';
$bottomfullwidth = 'span12';

// Reset layout mark-up for RTL languages.
if (right_to_left()) {
    $topfullwidth = 'span12';
	$regionmainbox = 'span9 pull-right';
    $upperfullwidth = 'span12';
    $regionmain = 'span8';
    $sidepre = 'span4 pull-right';
    $sidepost = 'span3 desktop-first-column';
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

<header role="banner" class="navbar navbar-fixed-top moodle-has-zindex">
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
            <?php echo $OUTPUT->navbar_home(false); ?>
            <?php echo $OUTPUT->navbar_button(); ?>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
                    <li class="navbar-text"><?php echo $OUTPUT->login_info(false) ?></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div id="page" class="container-fluid">

    <header id="page-header" class="clearfix">
        <?php echo $html->heading; ?>
    </header>

    <div id="page-content" class="row-fluid">
       <?php
		if ($hastopfullwidth)  {
			echo $OUTPUT->blocks('top-fullwidth', $topfullwidth);
		}
		?>
        <div id="region-main-box" class="<?php echo $regionmainbox; ?>">
            <div class="row-fluid">
                <section id="region-main" class="<?php echo $regionmain; ?>">
                   <?php
					if ($hasupperfullwidth)  {
						echo $OUTPUT->blocks('upper-fullwidth', $upperfullwidth); 
					}
					?>
                    <?php echo $OUTPUT->main_content(); ?>
                    <?php
                    if ($haslowerfullwidth)  {
						echo $OUTPUT->blocks('lower-fullwidth', $lowerfullwidth); 
					}
					?>
                </section>
                <?php echo $OUTPUT->blocks('side-pre', $sidepre); ?>
            </div>
        </div>
        <?php echo $OUTPUT->blocks('side-post', $sidepost); ?>
    </div>
    <div class="row-fluid">
     <?php
	if ($hasbottomfullwidth)  {
		echo $OUTPUT->blocks('bottom-fullwidth', $bottomfullwidth); 
	}
	?>
	</div>
</div>
</body>
</html>
