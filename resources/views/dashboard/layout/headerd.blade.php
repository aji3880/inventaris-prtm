<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid align-items-end">
            <div class="header-wrap flex justify-content-end">
                <div class="header-button">
                    <div class="account-wrap align-content-md-end">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="images/icon/avatar-01.jpg" />
                            </div>
                            <div class="content">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                        {{ auth()->user()->name }}
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            {{ auth()->user()->name }}
                                        </h5>
                                        <span class="email">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                <div class="account-dropdown__item">
                                    <div class="account-dropdown__item text-lg-center p-0">
                                        <form action="/logout" method="post">
                                            @csrf
                                            <button class="btn btn-outline-primary"><i class="zmdi zmdi-layers-off"></i> Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
