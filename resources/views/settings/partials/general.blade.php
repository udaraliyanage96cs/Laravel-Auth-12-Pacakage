<div id="general-settings" class="content col-12">
    <form action="{{ route('settings.store') }}" method="POST">
        @csrf
        <div class="col-md-12">
            <div class="content-header mb-3">
                <h6 class="mb-0">General Settings</h6>
            </div>
            <div class="row g-3">
                <div class="col-sm-12">
                    <label class="form-label" for="site_name">Site Name</label>
                    <input type="text" id="site_name" name="site_name" class="form-control" required
                        placeholder="Udarax" value="{{ config('app.name') }}" />
                    <p class="form-text">
                        Update the site name to reflect your brand or business identity. Changes will be
                        applied across the system wherever the site name is displayed.
                    </p>
                    @if ($errors->has('site_name'))
                        <div style="color: red; mt-2">
                            <span>{{ $errors->first('site_name') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end mt-3">
                <input class="btn btn-success" type="submit" value="Update">
            </div>
        </div>
    </form>
</div>
