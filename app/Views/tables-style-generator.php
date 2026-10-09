<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Tables Style Generator")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Tables Style Generator", "pageSubTitle1" => "Design", "pageSubTitle2" => "Tables", "pageSubText" => "Create custom Bootstrap table styles with live preview.")) ?>

                    <div class="main-content" >
                        <div class="info-container mb-4">
                            This tool helps you generate Bootstrap table styles by selecting different styling options.
                            The table updates in real-time as you make selections. Copy the generated classes to use in your project.
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card shadow-0 mb-g">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="card-title">Table Preview</div>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Column display options">
                                            <input type="radio" class="btn-check" name="columnsDisplay" id="collapseColumnsBtn" autocomplete="off">
                                            <label class="btn btn-outline-secondary" for="collapseColumnsBtn">Fewer Columns</label>

                                            <input type="radio" class="btn-check" name="columnsDisplay" id="expandColumnsBtn" autocomplete="off" checked>
                                            <label class="btn btn-outline-secondary" for="expandColumnsBtn">More Columns</label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="tableContainer">
                                            <table id="stylePreviewTable" class="table table-bordered table-striped table-hover">
                                                <caption>List of users and their details</caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Phone</th>
                                                        <th scope="col" class="d-none d-md-table-cell">Address</th>
                                                        <th scope="col" class="d-none d-md-table-cell">City</th>
                                                        <th scope="col" class="d-none d-lg-table-cell">State</th>
                                                        <th scope="col" class="d-none d-lg-table-cell">Country</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="table-primary">
                                                        <th scope="row">1</th>
                                                        <td>John Doe</td>
                                                        <td>john.doe@example.com</td>
                                                        <td>123-456-7890</td>
                                                        <td class="d-none d-md-table-cell">123 Main St</td>
                                                        <td class="d-none d-md-table-cell">Anytown</td>
                                                        <td class="d-none d-lg-table-cell">CA</td>
                                                        <td class="d-none d-lg-table-cell">USA</td>
                                                        <td><a href="javascript:void(0);">Edit</a></td>
                                                    </tr>
                                                    <tr class="table-secondary">
                                                        <th scope="row">2</th>
                                                        <td>Jane Smith</td>
                                                        <td>jane.smith@example.com</td>
                                                        <td>987-654-3210</td>
                                                        <td class="d-none d-md-table-cell">456 Park Ave</td>
                                                        <td class="d-none d-md-table-cell">Somecity</td>
                                                        <td class="d-none d-lg-table-cell">NY</td>
                                                        <td class="d-none d-lg-table-cell">USA</td>
                                                        <td><a href="javascript:void(0);">Edit</a></td>
                                                    </tr>
                                                    <tr class="table-success">
                                                        <th scope="row">3</th>
                                                        <td>Bob Johnson</td>
                                                        <td>bob.johnson@example.com</td>
                                                        <td>555-123-4567</td>
                                                        <td class="d-none d-md-table-cell">789 Oak Dr</td>
                                                        <td class="d-none d-md-table-cell">Otherville</td>
                                                        <td class="d-none d-lg-table-cell">TX</td>
                                                        <td class="d-none d-lg-table-cell">USA</td>
                                                        <td><a href="javascript:void(0);">Edit</a></td>
                                                    </tr>
                                                    <tr class="table-warning">
                                                        <th scope="row">4</th>
                                                        <td>Alice Brown</td>
                                                        <td>alice.brown@example.com</td>
                                                        <td>896-456-7890</td>
                                                        <td class="d-none d-md-table-cell">321 Maple St</td>
                                                        <td class="d-none d-md-table-cell">Newtown</td>
                                                        <td class="d-none d-lg-table-cell">FL</td>
                                                        <td class="d-none d-lg-table-cell">USA</td>
                                                        <td><a href="javascript:void(0);">Edit</a></td>
                                                    </tr>
                                                    <tr class="table-danger">
                                                        <th scope="row">5</th>
                                                        <td>Charlie Wilson</td>
                                                        <td>charlie.wilson@example.com</td>
                                                        <td>234-456-7890</td>
                                                        <td class="d-none d-md-table-cell">654 Pine Ln</td>
                                                        <td class="d-none d-md-table-cell">Lastcity</td>
                                                        <td class="d-none d-lg-table-cell">WA</td>
                                                        <td class="d-none d-lg-table-cell">USA</td>
                                                        <td><a href="javascript:void(0);">Edit</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            <h6>Configuration Code</h6>
                                            <pre class="body-bg p-3 border rounded"><code>&lt;table class="<span id="codeClasses">table</span>"&gt;
  &lt;caption&gt;List of users and their details&lt;/caption&gt;
  &lt;thead&gt;
    &lt;tr&gt;
      &lt;th scope="col"&gt;#&lt;/th&gt;
      &lt;th scope="col"&gt;Name&lt;/th&gt;
      &lt;th scope="col"&gt;Email&lt;/th&gt;
      &lt;!-- more columns --&gt;
    &lt;/tr&gt;
  &lt;/thead&gt;
  &lt;tbody&gt;
    &lt;tr&gt;
      &lt;th scope="row"&gt;1&lt;/th&gt;
      &lt;td&gt;John Doe&lt;/td&gt;
      &lt;td&gt;john.doe@example.com&lt;/td&gt;
      &lt;!-- more cells --&gt;
    &lt;/tr&gt;
    &lt;!-- more rows --&gt;
  &lt;/tbody&gt;
&lt;/table&gt;</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper-right">
                    <div class="right-content bg-faded d-flex flex-column h-100 pt-4">
                        <div class="flex-grow-1 p-3">
                            <form id="tableStyleForm">
                                <!-- Table Theme -->
                                <div class="mod-status primary-mod mt-1 pt-4 pb-3" data-prefix="Table Theme">
                                    <div class="btn-group btn-group-sm w-100" role="group" aria-label="Table theme options">
                                        <input type="radio" class="btn-check" name="tableTheme" id="themeDefault" value="" checked>
                                        <label class="btn btn-outline-secondary" for="themeDefault">Default</label>

                                        <input type="radio" class="btn-check" name="tableTheme" id="themeDark" value="table-dark">
                                        <label class="btn btn-outline-secondary" for="themeDark">Dark</label>

                                        <input type="radio" class="btn-check" name="tableTheme" id="themeLight" value="table-light">
                                        <label class="btn btn-outline-secondary" for="themeLight">Light</label>
                                    </div>
                                </div>

                                <!-- Table Styles -->
                                <div class="mod-status primary-mod mt-1 pt-4 pb-3" data-prefix="Table Styles">
                                    <div class="mb-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="tableStyle" id="styleStriped" value="table-striped">
                                            <label class="form-check-label" for="styleStriped">Striped rows</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="tableStyle" id="styleHover" value="table-hover">
                                            <label class="form-check-label" for="styleHover">Hover effect</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="tableStyle" id="styleBordered" value="table-bordered">
                                            <label class="form-check-label" for="styleBordered">Bordered</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="tableStyle" id="styleBorderless" value="table-borderless">
                                            <label class="form-check-label" for="styleBorderless">Borderless</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="tableStyle" id="styleResponsive" value="table-responsive" checked>
                                            <label class="form-check-label" for="styleResponsive">Responsive</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Size Options -->
                                <div class="mod-status primary-mod mt-1 pt-4 pb-3" data-prefix="Size Options">
                                    <div class="btn-group btn-group-sm w-100" role="group" aria-label="Table size options">
                                        <input type="radio" class="btn-check" name="tableSize" id="sizeDefault" value="" checked>
                                        <label class="btn btn-outline-secondary" for="sizeDefault">Default</label>

                                        <input type="radio" class="btn-check" name="tableSize" id="sizeSm" value="table-sm">
                                        <label class="btn btn-outline-secondary" for="sizeSm">Small</label>

                                        <input type="radio" class="btn-check" name="tableSize" id="sizeNano" value="table-nano">
                                        <label class="btn btn-outline-secondary" for="sizeNano">Nano</label>
                                    </div>
                                </div>

                                <!-- Table Accent -->
                                <div class="mod-status primary-mod mt-1 pt-4 pb-3" data-prefix="Table Accent">
                                    <select class="form-select" id="tableAccent">
                                        <option value="">None</option>
                                        <option value="table-primary">Primary</option>
                                        <option value="table-secondary">Secondary</option>
                                        <option value="table-success">Success</option>
                                        <option value="table-danger">Danger</option>
                                        <option value="table-warning">Warning</option>
                                        <option value="table-info">Info</option>
                                    </select>
                                    <div class="form-text fs-nano">
                                        Table theme must be set default to use this option.
                                    </div>
                                </div>

                                <!-- Header Accent -->
                                <div class="mod-status primary-mod mt-1 pt-4 pb-3" data-prefix="Header Accent (thead)">
                                    <select class="form-select" id="headerAccent">
                                        <option value="">None</option>
                                        <option value="table-primary">Primary</option>
                                        <option value="table-secondary">Secondary</option>
                                        <option value="table-success">Success</option>
                                        <option value="table-danger">Danger</option>
                                        <option value="table-warning">Warning</option>
                                        <option value="table-info">Info</option>
                                        <option value="table-dark">Dark</option>
                                        <option value="table-light">Light</option>
                                    </select>
                                </div>

                                <!-- Caption Styling -->
                                <div class="mod-status primary-mod mt-1 pt-4 pb-3" data-prefix="Caption Position">
                                    <div class="btn-group btn-group-sm w-100" role="group" aria-label="Caption position options">
                                        <input type="radio" class="btn-check" name="captionPosition" id="captionDefault" value="" checked>
                                        <label class="btn btn-outline-secondary" for="captionDefault">Default</label>

                                        <input type="radio" class="btn-check" name="captionPosition" id="captionTop" value="caption-top">
                                        <label class="btn btn-outline-secondary" for="captionTop">Top</label>

                                        <input type="radio" class="btn-check" name="captionPosition" id="captionBottom" value="caption-bottom">
                                        <label class="btn btn-outline-secondary" for="captionBottom">Bottom</label>
                                    </div>
                                </div>

                                <!-- Row Styling Preview -->
                                <div class="mod-status primary-mod mt-1 pt-4 pb-3" data-prefix="Row Styling">
                                    <div class="form-text mb-2">Show example rows with contextual classes</div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="showRowClasses">
                                        <label class="form-check-label" for="showRowClasses">Show row contextual classes</label>
                                    </div>
                                </div>
                            </form>

                            <div class="mt-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-bold">Generated Class:</span>
                                </div>
                                <code class="d-block p-2 body-bg border rounded" id="generatedClasses">table</code>
                            </div>
                            <div class="d-flex justify-content-between gap-2">
                                <button type="button" class="btn btn-primary mt-4 flex-grow-1" id="resetStylesBtn">Reset</button>
                                <button type="button" class="btn btn-success mt-4 flex-grow-1 d-flex align-items-center justify-content-center gap-2 js-waves-off" id="copyStyleBtn">
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?= $this->include('partials/app-footer') ?>

        </main>

        <?= $this->include('partials/app-drawer') ?>

        <?= $this->include('partials/app-settings') ?>

    </div>

    <?= $this->include('partials/app-scripts') ?>

    <script src="scripts/pages/tablesstylegenerator.js"></script>

</body>

</html>