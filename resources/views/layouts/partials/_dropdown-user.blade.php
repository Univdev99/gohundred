@if(isset($namefirstchar))
<!--begin: Head -->
<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(/assets/media/misc/bg-1.jpg)">
    <div class="kt-user-card-v2">
        <div class="kt-user-card-v2__pic">
            <div class="kt-badge kt-badge--xl kt-badge--success">

                {{ $namefirstchar }}

            </div>
        </div>
    </div>
    <div class="kt-user-card__name">{{ Auth::user()->name }} </div>
    <!-- <div class="kt-user-card__badge"> <span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span> </div> -->
</div>
<!--end: Head -->
<!--begin: Navigation -->
<div class="kt-notification">
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon-calendar-with-a-clock-time-tools kt-font-success"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> Current Plan </div>
            <div class="kt-notification__item-time"> Personal </div>
        </div>
    </a>
    <button class="kt-notification__item" id="slack-modal-button" style="width: 100%;border: 0;text-align: left;margin: 0;border-bottom: 1px solid #f7f8fa;padding: 1.1rem 1.5rem;background-color: transparent;">
        <div class="kt-notification__item-icon"> <i class="fab fa-slack kt-font-warning"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> Slack </div>
            <div class="kt-notification__item-time"> Add or disable </div>
        </div>
    </button>
    <a href="{{  route('excelExport') }}" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="fas fa-file-excel kt-font-primary"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> Export excel file </div>
            <!-- <div class="kt-notification__item-time"> Logs and notifications </div> -->
        </div>
    </a>
    <a href="{{ route('plans.show') }}" class="kt-notification__item">
        <div class="kt-notification__item-icon">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <path d="M7,5 L17,5 C17.5522847,5 18,5.44771525 18,6 C18,6.55228475 17.5522847,7 17,7 L7,7 C6.44771525,7 6,6.55228475 6,6 C6,5.44771525 6.44771525,5 7,5 Z M7,9 L17,9 C17.5522847,9 18,9.44771525 18,10 C18,10.5522847 17.5522847,11 17,11 L7,11 C6.44771525,11 6,10.5522847 6,10 C6,9.44771525 6.44771525,9 7,9 Z M7,13 L17,13 C17.5522847,13 18,13.4477153 18,14 C18,14.5522847 17.5522847,15 17,15 L7,15 C6.44771525,15 6,14.5522847 6,14 C6,13.4477153 6.44771525,13 7,13 Z M7,17 L17,17 C17.5522847,17 18,17.4477153 18,18 C18,18.5522847 17.5522847,19 17,19 L7,19 C6.44771525,19 6,18.5522847 6,18 C6,17.4477153 6.44771525,17 7,17 Z" fill="#000000" opacity="0.3"></path>
                    <path d="M5.5,2 C6.32842712,2 7,2.67157288 7,3.5 L7,20.5 C7,21.3284271 6.32842712,22 5.5,22 C4.67157288,22 4,21.3284271 4,20.5 L4,3.5 C4,2.67157288 4.67157288,2 5.5,2 Z M18.5,2 C19.3284271,2 20,2.67157288 20,3.5 L20,20.5 C20,21.3284271 19.3284271,22 18.5,22 C17.6715729,22 17,21.3284271 17,20.5 L17,3.5 C17,2.67157288 17.6715729,2 18.5,2 Z" fill="#000000"></path>
                </g>
            </svg>
        </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> Upgrade plan </div>
        </div>
    </a>
    <div >
    <a href="{{ route('logout') }}" class="kt-notification__item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <div class="kt-notification__item-icon"> <i class="fas fa-power-off kt-font-danger"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title">{{ __('Logout')}}</div>
        </div>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    </form>
    </div>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="fas fa-user-times kt-font-dark"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title"> Delete my account </div>
        </div>
    </a>
</div>
<!--end: Navigation -->
@endif
