<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 *
 * @version $Id: display_import.lib.php 12045 2008-11-30 13:53:40Z nijel $
 * @package phpMyAdmin
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 *
 */
require_once './libraries/file_listing.php';
require_once './libraries/plugin_interface.lib.php';

/* Scan for plugins */
$import_list = PMA_getPlugins('./libraries/import/', $import_type);

/* Fail if we didn't find any plugin */
if (empty($import_list)) {
    PMA_Message::error('strCanNotLoadImportPlugins')->display();
    require './libraries/footer.inc.php';
}
?>

<form action="import.php" method="post" enctype="multipart/form-data" name="import">
<?php
if ($import_type == 'server') {
    echo PMA_generate_common_hidden_inputs('', '', 1);
} elseif ($import_type == 'database') {
    echo PMA_generate_common_hidden_inputs($db, '', 1);
} else {
    echo PMA_generate_common_hidden_inputs($db, $table, 1);
}
echo '    <input type="hidden" name="import_type" value="' . $import_type . '" />';
echo PMA_pluginGetJavascript($import_list);
?>
    <fieldset class="options">
        <legend><?php echo $strFileToImport; ?></legend>

<?php
if ($GLOBALS['is_upload']) {
    ?>
        <div class="formelementrow">
        <label for="input_import_file"><?php echo $strLocationTextfile; ?></label>
        <input style="margin: 5px" type="file" name="import_file" id="input_import_file" onchange="match_file(this.value);" />
    <?php
    echo PMA_displayMaximumUploadSize($max_upload_size) . "\n";
    // some browsers should respect this :)
    echo PMA_generateHiddenMaxFileSize($max_upload_size) . "\n";
    ?>
        </div>
    <?php
} else {
    PMA_Message::warning('strUploadsNotAllowed')->display();
}
if (!empty($cfg['UploadDir'])) {
    $extensions = '';
    foreach ($import_list as $key => $val) {
        if (!empty($extensions)) {
            $extensions .= '|';
        }
        $extensions .= $val['extension'];
    }
    $matcher = '@\.(' . $extensions . ')(\.(' . PMA_supportedDecompressions() . '))?$@';

    $files = PMA_getFileSelectOptions(PMA_userDir($cfg['UploadDir']), $matcher, (isset($timeout_passed) && $timeout_passed && isset($local_import_file)) ? $local_import_file : '');
    echo '<div class="formelementrow">' . "\n";
    if ($files === FALSE) {
        PMA_Message::error('strWebServerUploadDirectoryError')->display();
    } elseif (!empty($files)) {
        echo "\n";
        echo '    <i>' . $strOr . '</i><br/><label for="select_local_import_file">' . $strWebServerUploadDirectory . '</label>&nbsp;: ' . "\n";
        echo '    <select style="margin: 5px" size="1" name="local_import_file" onchange="match_file(this.value)" id="select_local_import_file">' . "\n";
        echo '        <option value="">&nbsp;</option>' . "\n";
        echo $files;
        echo '    </select>' . "\n";
    }
    echo '</div>' . "\n";
} // end if (web-server upload directory)

// charset of file
echo '<div class="formelementrow">' . "\n";
if ($cfg['AllowAnywhereRecoding']) {
    echo '<label for="charset_of_file">' . $strCharsetOfFile . '</label>';
    reset($cfg['AvailableCharsets']);
    echo '<select id="charset_of_file" name="charset_of_file" size="1">';
    foreach ($cfg['AvailableCharsets'] as $temp_charset) {
        echo '<option value="' . htmlentities($temp_charset) .  '"';
        if ((empty($cfg['Import']['charset']) && $temp_charset == $charset)
          || $temp_charset == $cfg['Import']['charset']) {
            echo ' selected="selected"';
        }
        echo '>' . htmlentities($temp_charset) . '</option>';
    }
    echo ' </select><br />';
} else {
    echo '<label for="charset_of_file">' . $strCharsetOfFile . '</label>' . "\n";
    echo PMA_generateCharsetDropdownBox(PMA_CSDROPDOWN_CHARSET, 'charset_of_file', 'charset_of_file', 'utf8', FALSE);
} // end if (recoding)
echo '</div>' . "\n";

// zip, gzip and bzip2 encode features
$compressions = $strNone;

if ($cfg['GZipDump'] && @function_exists('gzopen')) {
    $compressions .= ', gzip';
}
if ($cfg['BZipDump'] && @function_exists('bzopen')) {
    $compressions .= ', bzip2';
}
if ($cfg['ZipDump'] && @function_exists('zip_open')) {
    $compressions .= ', zip';
}

// We don't have show anything about compression, when no supported
if ($compressions != $strNone) {
    echo '<div class="formelementrow">' . "\n";
    printf($strCompressionWillBeDetected, $compressions);
    echo '</div>' . "\n";
}
echo "\n";
?>
    </fieldset>
    <fieldset class="options">
        <legend><?php echo $strPartialImport; ?></legend>

        <?php
        if (isset($timeout_passed) && $timeout_passed) {
            echo '<div class="formelementrow">' . "\n";
            echo '<input type="hidden" name="skip" value="' . $offset . '" />';
            echo sprintf($strTimeoutInfo, $offset) . '';
            echo '</div>' . "\n";
        }
        ?>
        <div class="formelementrow">
        <input type="checkbox" name="allow_interrupt" value="yes"
            id="checkbox_allow_interrupt" <?php echo PMA_pluginCheckboxCheck('Import', 'allow_interrupt'); ?>/>
        <label for="checkbox_allow_interrupt"><?php echo $strAllowInterrupt; ?></label><br />
        </div>

        <?php
        if (! (isset($timeout_passed) && $timeout_passed)) {
        ?>
        <div class="formelementrow">
        <label for="text_skip_queries"><?php echo $strSkipQueries; ?></label>
        <input type="text" name="skip_queries" value="<?php echo PMA_pluginGetDefault('Import', 'skip_queries');?>" id="text_skip_queries" />
        </div>
        <?php
        } else {
        // If timeout has passed,
        // do not show the Skip dialog to avoid the risk of someone
        // entering a value here that would interfere with "skip"
        ?>
        <input type="hidden" name="skip_queries" value="<?php echo PMA_pluginGetDefault('Import', 'skip_queries');?>" id="text_skip_queries" />
        <?php
        }
        ?>
    </fieldset>

    <fieldset class="options">
        <legend><?php echo $strImportFormat; ?></legend>
<?php
// Let's show format options now
echo '<div style="float: left;">';
echo PMA_pluginGetChoice('Import', 'format', $import_list);
echo '</div>';

echo '<div style="float: left;">';
echo PMA_pluginGetOptions('Import', $import_list);
echo '</div>';
?>
        <div class="clearfloat"></div>
    </fieldset>
<?php
// Encoding setting form appended by Y.Kawada
if (function_exists('PMA_set_enc_form')) {
    echo PMA_set_enc_form('            ');
}
echo "\n";
?>
    <fieldset class="tblFooters">
        <input type="submit" value="<?php echo $strGo; ?>" id="buttonGo" />
    </fieldset>
</form>
<script type="text/javascript">
//<![CDATA[
    init_options();
//]]>
</script>
