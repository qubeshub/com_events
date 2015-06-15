<?php
/**
 * HUBzero CMS
 *
 * Copyright 2005-2011 Purdue University. All rights reserved.
 *
 * This file is part of: The HUBzero(R) Platform for Scientific Collaboration
 *
 * The HUBzero(R) Platform for Scientific Collaboration (HUBzero) is free
 * software: you can redistribute it and/or modify it under the terms of
 * the GNU Lesser General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * HUBzero is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * HUBzero is a registered trademark of Purdue University.
 *
 * @package   hubzero-cms
 * @author    Shawn Rice <zooley@purdue.edu>
 * @copyright Copyright 2005-2011 Purdue University. All rights reserved.
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPLv3
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

$this->css()
     ->js();
?>
<header id="content-header">
	<h2><?php echo $this->title; ?></h2>

	<?php if ($this->authorized) { ?>
	<div id="content-header-extra">
		<ul id="useroptions">
			<li class="last"><a class="icon-add add btn" href="<?php echo Route::url('index.php?option='.$this->option.'&task=add'); ?>"><?php echo Lang::txt('EVENTS_ADD_EVENT'); ?></a></li>
		</ul>
	</div><!-- / #content-header-extra -->
	<?php } ?>
</header><!-- / #content-header -->

<nav>
	<ul class="sub-menu">
		<li<?php if ($this->task == 'year') { echo ' class="active"'; } ?>><a href="<?php echo Route::url('index.php?option='.$this->option.'&year='.$this->year); ?>"><span><?php echo Lang::txt('EVENTS_CAL_LANG_REP_YEAR'); ?></span></a></li>
		<li<?php if ($this->task == 'month') { echo ' class="active"'; } ?>><a href="<?php echo Route::url('index.php?option='.$this->option.'&year='.$this->year.'&month='.$this->month); ?>"><span><?php echo Lang::txt('EVENTS_CAL_LANG_REP_MONTH'); ?></span></a></li>
		<li<?php if ($this->task == 'week') { echo ' class="active"'; } ?>><a href="<?php echo Route::url('index.php?option='.$this->option.'&year='.$this->year.'&month='.$this->month.'&day='.$this->day.'&task=week'); ?>"><span><?php echo Lang::txt('EVENTS_CAL_LANG_REP_WEEK'); ?></span></a></li>
		<li<?php if ($this->task == 'day') { echo ' class="active"'; } ?>><a href="<?php echo Route::url('index.php?option='.$this->option.'&year='.$this->year.'&month='.$this->month.'&day='.$this->day); ?>"><span><?php echo Lang::txt('EVENTS_CAL_LANG_REP_DAY'); ?></span></a></li>
	</ul>
</nav>

<section class="main section noaside">
	<h3><?php echo stripslashes($this->event->title); ?></h3>
	<?php
		$html  = '<div id="sub-sub-menu">'."\n";
		$html .= '<ul>'."\n";
		$html .= "\t".'<li';
		if ($this->page->alias == '') {
			$html .= ' class="active"';
		}
		$html .= '><a class="tab" href="'. Route::url('index.php?option='.$this->option.'&task=details&id='.$this->event->id) .'"><span>'.Lang::txt('EVENTS_OVERVIEW').'</span></a></li>'."\n";
		if ($this->pages) {
			foreach ($this->pages as $p)
			{
				$html .= "\t".'<li';
				if ($this->page->alias == $p->alias) {
					$html .= ' class="active"';
				}
				$html .= '><a class="tab" href="'. Route::url('index.php?option='.$this->option.'&task=details&id='.$this->event->id.'&page='.$p->alias) .'"><span>'.trim(stripslashes($p->title)).'</span></a></li>'."\n";
			}
		}
		$html .= "\t".'<li';
		if ($this->page->alias == 'register') {
			$html .= ' class="active"';
		}
		$html .= '><a class="tab" href="'. Route::url('index.php?option='.$this->option.'&task=details&id='.$this->event->id.'&page=register') .'"><span>'.Lang::txt('EVENTS_REGISTER').'</span></a></li>'."\n";
		$html .= '</ul>'."\n";
		$html .= '<div class="clear"></div>'."\n";
		$html .= '</div>'."\n";
		echo $html;
	?>

	<?php if ($this->getError()) { ?>
		<p class="error"><?php echo $this->getError(); ?></p>
	<?php } ?>

	<form method="post" action="index.php" id="hubForm">
		<p class="passed"><?php echo Lang::txt('EVENTS_REGISTRATION_COMPLETE'); ?></p>
	</form>
</section><!-- / .main section -->
