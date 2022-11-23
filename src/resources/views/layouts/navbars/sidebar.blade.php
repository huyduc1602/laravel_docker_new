  <div class="navigation col-2">
      <div class="logo">
          <a href="https://vn.ids.jp/" class="text-decoration-none">
              <img style="width: 15rem; height: 3rem"
                  src="https://www.pngkey.com/png/full/57-574447_transparent-sun-half-half-sun-logo-png.png"
                  alt="{{ __('IDS') }}">
          </a>
      </div>
      @isset(auth()->user()->role)
          @if (auth()->user()->role == 1)
              {
              <ul class="mt-5">
                  <li class="{{ $activePage == 'dashboard' ? ' active' : '' }}">
                      <a class="text-light" href="{{ route('dashboard') }}">
                          <span class="nav-icon"><i class="fa-solid fa-gauge"></i>
                              <span style="margin-left: 1rem;">{{ __('Dashboard') }}</ /span>
                              </span>
                      </a>
                  </li>
                  <li class="{{ $activePage == 'timesheet' ? ' active' : '' }}">
                      <a class="text-light" href="{{ route('timesheet') }}">
                          <span class="nav-icon"><i class="fa-solid fa-clock"></i>
                              <span style="margin-left: 1rem;">{{ __('My Times') }}</span>
                      </a>
                  </li>
              </ul>
          @else
              <ul class="mt-5">
                  <li class="{{ $activePage == 'dashboard' ? ' active' : '' }}">
                      <a class="text-light" href="{{ route('admin.dashboard') }}">
                          <span class="nav-icon"><i class="fa-solid fa-chart-line"></i>
                              <span style="margin-left: 1rem;">{{ __('Dashboard') }}</span>
                              </span>
                      </a>
                  </li>
                  <li class="{{ $activePage == 'timesheet' ? ' active' : '' }}">
                      <a class="text-light" href="{{ route('admin.pageT') }}">
                          <span class="nav-icon"><i class="fa-solid fa-list"></i>
                              <span style="margin-left: 1rem;">{{ __('Times List') }}</span>
                      </a>
                  </li>
                  <li class="{{ $activePage == 'timesheet' ? ' active' : '' }}">
                      <a class="text-light" href="{{ route('timesheet') }}">
                          <span class="nav-icon"><i class="fa-solid fa-clock"></i>
                              <span style="margin-left: 1rem;">{{ __('My Times') }}</span>
                      </a>
                  </li>
                  <li class="{{ $activePage == 'users' ? ' active' : '' }}">
                    <a class="text-light" href="{{ route('admin.pageU') }}">
                        <span class="nav-icon"><i class="fa-solid fa-user-group"></i>
                            <span style="margin-left: 1rem;">{{ __('Member') }}</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'projects' ? ' active' : '' }}">
                    <a class="text-light" href="{{ route('admin.pageP') }}">
                        <span class="nav-icon"><i class="fa-solid fa-diagram-project"></i>
                            <span style="margin-left: 1rem;">{{ __('Project') }}</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'activities' ? ' active' : '' }}">
                    <a class="text-light" href="{{ route('admin.pageA') }}">
                        <span class="nav-icon"><i class="fa-brands fa-angrycreative"></i>
                            <span style="margin-left: 1rem;">{{ __('Activities') }}</span>
                    </a>
                </li>
              </ul>
          @endif
      @endisset

  </div>

  @push('js')
      <script type="text/javascript">
          $('.navigation').hover(function() {
              var $
          }, function() {

          })
      </script>
  @endpush
