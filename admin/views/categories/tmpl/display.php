<?php
/**
 * HUBzero CMS
 *
 * Copyright 2005-2015 HUBzero Foundation, LLC.
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
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPLv3
 */

// No direct access
defined('_HZEXEC_') or die();

Toolbar::title(Lang::txt('COM_EVENTS_MANAGER').': '.Lang::txt('COM_EVENTS_CAL_LANG_EVENT_CATEGORIES'), 'event.png');
Toolbar::publishList();
Toolbar::unpublishList();
Toolbar::spacer();
Toolbar::addNew();
Toolbar::editList();
Toolbar::deleteList();

Html::behavior('tooltip');
?>
<form action="<?php echo Route::url('index.php?option=' . $this->option); ?>" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows);?>);" /></th>
				<th scope="col"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CATEGORY_NAME'); ?></th>
				<th scope="col"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CATEGORY_NUM_RECORDS'); ?></th>
				<th scope="col"><?php echo Lang::txt('COM_EVENTS_E_PUBLISHING'); ?></th>
				<th scope="col"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_EVENT_ACCESS'); ?></th>
				<th scope="col" colspan="2"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CATEGORY_REORDER'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10"><?php
				// Initiate paging
				$pageNav = $this->pagination(
					$this->total,
					$this->limitstart,
					$this->limit
				);
				echo $pageNav->render();
				?></td>
			</tr>
		</tfoot>
		<tbody>
<?php
	$k = 0;
	for ($i=0, $n=count($this->rows); $i < $n; $i++)
	{
		$row = &$this->rows[$i];
		$class = $row->published ? 'published' : 'unpublished';
		$alt = $row->published ? 'Published' : 'Unpublished';
		$task = $row->published ? 'unpublish' : 'publish';

		if ($row->groupname == 'Public') {
			$color_access = 'style="color: green;"';
		} else if ($row->groupname == 'Special') {
			$color_access = 'style="color: red;"';
		} else {
			$color_access = 'style="color: black;"';
		}
?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $row->id; ?>
				</td>
				<td>
<?php if ($row->checked_out && $row->checked_out != User::get('id')) { ?>
					&nbsp;
<?php } else { ?>
					<input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" />
<?php } ?>
				</td>
				<td>
<?php if ($row->checked_out && $row->checked_out != User::get('id')) { ?>
					<span class="checkedout hasTip" title="Checked out::<?php echo $row->editor; ?>">
						<?php echo $this->escape(stripslashes($row->name)); ?> <?php echo $this->escape(stripslashes($row->title)); ?>
					</span>
<?php } else { ?>
					<a href="<?php echo Route::url('index.php?option=' . $this->option . '&controller=' . $this->controller . '&task=edit&id=' . $row->id); ?>">
						<?php echo $this->escape(stripslashes($row->name)); ?> &mdash; <?php echo $this->escape(stripslashes($row->title)); ?>
					</a>
<?php } ?>
				</td>
				<td>
					<?php echo $row->num; ?>
				</td>
				<td>
					<a class="state <?php echo $class;?>" href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo $task; ?>')">
						<span><?php echo $alt; ?></span>
					</a>
				</td>
				<td>
					<span <?php echo $color_access;?>>
						<?php echo $this->escape(stripslashes($row->groupname)); ?>
					</span>
				</td>
				<td>
				<?php if ($i > 0 || ($i+$this->pageNav->limitstart > 0)) { ?>
					<a href="#reorder" class="order up jgrid" onclick="return listItemTask('cb<?php echo $i;?>','orderup')" title="Move Up">
						<span class="state uparrow"><span><?php echo Lang::txt('COM_EVENTS_MOVE_UP'); ?></span></span>
					</a>
				<?php } else { ?>
					&nbsp;
				<?php } ?>
				</td>
				<td>
				<?php if ($i < $n-1 || $i+$this->pageNav->limitstart < $this->pageNav->total-1) { ?>
					<a href="#reorder" class="order down jgrid" onclick="return listItemTask('cb<?php echo $i;?>','orderdown')" title="Move Down">
						<span class="state downarrow"><span><?php echo Lang::txt('COM_EVENTS_MOVE_DOWN'); ?></span></span>
					</a>
				<?php } else { ?>
					&nbsp;
				<?php } ?>
				</td>
			</tr>
	<?php
		$k = 1 - $k;
	} // for loop
	?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
	<input type="hidden" name="controller" value="<?php echo $this->controller; ?>" />
	<input type="hidden" name="section" value="<?php echo $this->section; ?>" />
	<input type="hidden" name="task" value="" autocomplete="" />
	<input type="hidden" name="chosen" value="" />
	<input type="hidden" name="boxchecked" value="0" />

	<?php echo Html::input('token'); ?>
</form>
