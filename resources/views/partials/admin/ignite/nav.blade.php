@section('ignite::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li @if($activeTab === 'index')class="active"@endif><a href="{{ route('admin.index') }}">Home</a></li>
                    <li @if($activeTab === 'theme')class="active"@endif><a href="{{ route('admin.ignite.theme') }}">Appearance</a></li>
                    <li @if($activeTab === 'mail')class="active"@endif><a href="{{ route('admin.ignite.mail') }}">Mail</a></li>
                    <li @if($activeTab === 'advanced')class="active"@endif><a href="{{ route('admin.ignite.advanced') }}">Advanced</a></li>
                    <li style="margin-left: 5px; margin-right: 5px;"><a>-</a></li>
                    <li @if($activeTab === 'store')class="active"@endif><a href="{{ route('admin.ignite.store') }}">Storefront</a></li>
                    <li @if($activeTab === 'registration')class="active"@endif><a href="{{ route('admin.ignite.registration') }}">Registration</a></li>
                    <li @if($activeTab === 'approvals')class="active"@endif><a href="{{ route('admin.ignite.approvals') }}">Approvals</a></li>
                    <li @if($activeTab === 'server')class="active"@endif><a href="{{ route('admin.ignite.server') }}">Server Settings</a></li>
                    <li @if($activeTab === 'referrals')class="active"@endif><a href="{{ route('admin.ignite.referrals') }}">Referrals</a></li>
                    
                </ul>
            </div>
        </div>
    </div>
@endsection
