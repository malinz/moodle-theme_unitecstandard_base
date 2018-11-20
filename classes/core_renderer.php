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

require_once($CFG->dirroot . '/theme/bootstrapbase/renderers.php');

/**
 * unitecstandard_base core renderers.
 *
 * @package    theme_unitecstandard_base
 * @copyright  2015 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_unitecstandard_base_core_renderer extends theme_bootstrapbase_core_renderer {

		/**
     * Generates the HTML for the hide blocks button.
     *
     * Malcolm Hay 20/11/2018
     * @return string HTML.
     */
   public function hide_blocks_button() {
	   
        //return $this->page->button;
		return html_writer::start_tag('input', array('id' => 'hideShowButton', 'type' => 'button', 'value' => 'Hide Blocks', 'class' => 'hideBlocks-button', 'onclick' => 'hideBlocks()'));
	  
    }
	
	
	/**
     * Wrapper for header elements.
     * Extracted from moodle/lib.outputrenderers.php to add extra button to Breadcrumb Nav - Malcolm Hay
     * @return string HTML to display the main header.
     */
    public function full_header() {
		
        $html = html_writer::start_tag('header', array('id' => 'page-header', 'class' => 'clearfix'));
        $html .= $this->context_header();
        $html .= html_writer::start_div('clearfix', array('id' => 'page-navbar'));
        $html .= html_writer::tag('div', $this->navbar(), array('class' => 'breadcrumb-nav'));
		$html .= html_writer::div($this->page_heading_button(), 'breadcrumb-button');
		//Extra button added here
        $html .= html_writer::div($this->hide_blocks_button(), 'hideBlocks-button');
        $html .= html_writer::end_div();
        $html .= html_writer::tag('div', $this->course_header(), array('id' => 'course-header'));
        $html .= html_writer::end_tag('header');
        return $html;
    }

    /**
     * Either returns the parent version of the header bar, or a version with the logo replacing the header.
     *
     * @since Moodle 2.9
     * @param array $headerinfo An array of header information, dependant on what type of header is being displayed. The following
     *                          array example is user specific.
     *                          heading => Override the page heading.
     *                          user => User object.
     *                          usercontext => user context.
     * @param int $headinglevel What level the 'h' tag will be.
     * @return string HTML for the header bar.
     */
    public function context_header($headerinfo = null, $headinglevel = 1) {

        if ($this->should_render_logo($headinglevel)) {
            return html_writer::tag('div', '', array('class' => 'logo'));
        }
        return parent::context_header($headerinfo, $headinglevel);
    }

    /**
     * Determines if we should render the logo.
     *
     * @param int $headinglevel What level the 'h' tag will be.
     * @return bool Should the logo be rendered.
     */
    protected function should_render_logo($headinglevel = 1) {
        global $PAGE;

 	/**
     * Alternative code to always render logo regardless of the page.
     *
     * @param int $headinglevel What level the 'h' tag will be.
     * @return bool Should the logo be rendered.
     */
    protected function should_render_logo($headinglevel = 1) {
        global $PAGE;
		
		//render logo regardless of which page as long as the logo is set
		if ($headinglevel == 1 && !empty($this->page->theme->settings->logo)) {      
               return true;           
        }
		return false;
    }
    
        	   /**
     * Returns a reference to the site home. Alternative code
     *
     * It can be either a link or a span.
     *
     * @param bool $returnlink
     * @return string
     */
    protected function get_home_ref($returnlink = true) {
        global $CFG, $SITE;

        $sitename = format_string($SITE->shortname, true, array('context' => context_course::instance(SITEID)));

        if ($returnlink) {
            return html_writer::link($CFG->wwwroot, $sitename, array('class' => 'brand brandlogo', 'title' => get_string('home')));
        }

        return html_writer::tag('span', $sitename, array('class' => 'brand'));
    }

    /**
     * Returns the navigation bar home reference.
     *
     * The small logo is only rendered on pages where the logo is not displayed.
     *
     * @param bool $returnlink Whether to wrap the icon and the site name in links or not
     * @return string The site name, the small logo or both depending on the theme settings.
     */
      public function navbar_home($returnlink = true) {
        global $CFG;
				
		
		// Added code for a default Home icon when no Small Logo is defined - M.H.
		$defaulticon = '<i class="fa fa-home fa-lg">&nbsp;</i>'.get_string('homeicon', 'theme_unitecstandard');
		
		if ($returnlink) {
            $defaultlogocontainer = html_writer::link($CFG->wwwroot, $defaulticon,
                array('class' => 'small-logo-container default-icon', 'title' => get_string('home')));
        } else {
            $defaultlogocontainer = html_writer::tag('span', $defaulticon, array('class' => 'small-logo-container default-icon'));
        }

        if ($this->should_render_logo() || empty($this->page->theme->settings->smalllogo)) {
			
            			
			// Added code - If there is no small logo always show the default Home icon - M.H.
			return $defaultlogocontainer;
			
			
        }
	}


   /*
     * This code has been extracted from bootstrapbase core_renderer.php 
     * It renders the custom menu items for the bootstrap dropdown menu.
	 * A condtion has been inserted to apply a class to add a scroll bar to long menus without submenus.
     */
    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0 ) {
        static $submenucount = 0;

        $content = '';
        if ($menunode->has_children()) {

            if ($level == 1) {
                $class = 'dropdown';
            } else {
                $class = 'dropdown-submenu';
            }

            if ($menunode === $this->language) {
                $class .= ' langmenu';
            }
            $content = html_writer::start_tag('li', array('class' => $class));
            // If the child has menus render it as a sub menu.
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }
            $content .= html_writer::start_tag('a', array('href'=>$url, 'class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'title'=>$menunode->get_title()));
            $content .= $menunode->get_text();
            if ($level == 1) {
                $content .= '<b class="caret"></b>';
            }
            $content .= '</a>';
			/* check if the menu node has no sub-menu. Only enable scrolling if it does NOT have a sub menu. Added by Malcolm Hay*/
            if ($menunode->get_url() === null) {
				$content .= '<ul class="dropdown-menu ">';
		} else {
			$content .= '<ul class="dropdown-menu menu-scroll">';			
		}
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 0);
            }
            $content .= '</ul>';
        } else {
            // The node doesn't have children so produce a final menuitem.
            // Also, if the node's text matches '####', add a class so we can treat it as a divider.
            if (preg_match("/^#+$/", $menunode->get_text())) {
                // This is a divider.
                $content = '<li class="divider">&nbsp;</li>';
            } else {
                $content = '<li>';
                if ($menunode->get_url() !== null) {
                    $url = $menunode->get_url();
                } else {
                    $url = '#';
                }
                $content .= html_writer::link($url, $menunode->get_text(), array('title' => $menunode->get_title()));
                $content .= '</li>';
            }
        }
        return $content;
    }
		
	     /*added funtionality to display My Courses and My Dashboard to the custom menu 
		 ------------------------------------------------------------------------------*/
		
		protected function render_custom_menu(custom_menu $menu) {
    	/*
    	* This code adds the current enrolled
    	* courses to the custommenu.
    	*/
    
    	
        if (isloggedin() && !isguestuser()) {
			$branchlabel = '<i class="fa fa-briefcase">&nbsp;</i>'.get_string('mycourses', 'theme_unitecstandard');
            $branchurl   = new moodle_url('/my/index.php');
            $branchtitle = get_string('mycourses', 'theme_unitecstandard');
            $branchsort  = 10000;
 
            $branch = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
 			if ($courses = enrol_get_my_courses(NULL, 'fullname ASC')) {
 				foreach ($courses as $course) {
 					if ($course->visible){
 						$branch->add(format_string($course->fullname), new moodle_url('/course/view.php?id='.$course->id), format_string($course->shortname));
 					}
 				}
 			} else {
                $noenrolments = get_string('noenrolments', 'theme_unitecstandard');
 				$branch->add('<em>'.$noenrolments.'</em>', new moodle_url('/'), $noenrolments);
 			}
            
        }


        return parent::render_custom_menu($menu);
	}
	
}
