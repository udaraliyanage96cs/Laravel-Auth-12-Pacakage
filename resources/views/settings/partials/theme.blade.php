<div id="theme-settings" class="content">
    <form action="{{ route('settings.themesettings') }}" method="POST">
        @csrf
        <div>
            <div class="content-header mb-3">
                <h6 class="mb-0">Theme Settings</h6>
            </div>
            <div class="row g-3">
                <div class="col-sm-12">
                    <label class="form-label" for="site_name">Side Menu Color</label>
                    <div id="values"></div>
                    <div class="colorPicker mt-3"></div>
                    <div class="col-md-5  mt-3">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon11">Side Navbar
                                Colour</span>
                            <input id="hexInput" class="form-control" name="navColor"
                                aria-describedby="basic-addon11" readonly required></input>
                            <p class="form-text">Customize the side menu background color to match your
                                brand or personal preference. Changes will be applied instantly for a
                                personalized look and feel.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end mt-3">
                <input class="btn btn-success" type="submit" value="Update">
            </div>
        </div>
    </form>
</div>
