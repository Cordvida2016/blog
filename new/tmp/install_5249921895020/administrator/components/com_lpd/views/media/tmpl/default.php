<?php
/**
 * @version		$Id: default.php 1119 2011-10-11 15:32:04Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<script type="text/javascript">
	$LPD(document).ready(function() {
		var elf = $LPD('#elfinder').elfinder({
			url : '<?php echo JURI::base(true); ?>/index.php?option=com_lpd&view=media&task=connector',
			<?php if($this->mimes): ?>
			onlyMimes: [<?php echo $this->mimes; ?>],
			<?php endif; ?>
			<?php if($this->fieldID): ?>
			getFileCallback : function(file) {
				path = file.path;
				value = path.replace(/\\/g, '/');
				parent.elFinderUpdate('<?php echo $this->fieldID; ?>', value);
			}
			<?php else: ?>
			height: 600
			<?php endif; ?>
		}).elfinder('instance');
	});
</script>
<div id="elfinder"></div>
