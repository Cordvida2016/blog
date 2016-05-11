<div data-customizer>

    <select data-style-selector name="<?php echo $name ?>" data-selected="<?php echo $value ?>">
        <?php
        // less styles
        if ($path = $this['path']->path('less:styles')) {
            foreach (glob("$path/*.less") as $file) {
                $style = basename($file, '.less');
                printf('<option value="%s">%s</option>', $style, $style);
            }
        }
        ?>
    </select>

    <p>Use the customizer to create your own style. You can pick colors, modify sizes and much more with a real time theme preview. No CSS knowledge needed.</p>

    <a href="" class="uk-button">Customizer</a>

    <script type="text/template">

        <div id="customizer">

            <div class="cm-sidebar">

                <header class="cm-sidebar-header">

                    <h1 class="cm-sidebar-title">Select a style</h1>

                    <div class="uk-form">
                        <div class="uk-form-row">
                            <div class="uk-grid uk-preserve">
                                <select class="cm-form-width-small" name="style"></select>
                                <a href="#copy" class="uk-button">Copy</a>
                                <a href="#remove" class="uk-button">Delete</a>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label><input type="checkbox" name="advanced"> Advanced Mode</label>
                        </div>
                    </div>

                </header>

                <div class="uk-alert uk-alert-warning cm-sidebar-message"></div>

                <section class="cm-sidebar-content"></section>

                <footer class="cm-sidebar-footer">
                    <a href="#save" class="uk-button uk-button-primary">Save</a>
                    <a href="#reset" class="uk-button">Reset</a>
                    <a href="#cancel" class="uk-button">Cancel</a>
                </footer>

            </div>

            <div class="cm-wrapper">

                <i class="uk-icon-spinner uk-icon-spin cm-spinner"></i>
                <div class="uk-alert uk-alert-danger uk-alert-large cm-error"></div>
                <iframe id="cm-theme-preview" src="<?php echo $this['system']->url ?>"></iframe>

            </div>

        </div>

    </script>
</div>
