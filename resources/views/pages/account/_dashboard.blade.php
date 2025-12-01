@extends('layouts.app')

@section('show-nav', 'true')

<!-- Page head -->
@section('head')

<title>Dashboard || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main class="dash">
    @include('components.account.sidebar', ['page' => 'dashboard'])

    <section class="vlx-block vlx-block--dash wst--large wsb--medium bg--normal">
        <div class="container">
            <div class="content__header">
                <h1>Dashboard</h1>
                <p>Welcome back, {{ Auth::user()->name ?? 'User' }}!</p>
            </div>

            <section class="stats-cards">
                <div class="stat-card bg--light">
                    <div class="vlx-icon--wrapper">
                        <x-icon icon="users" size="large" />
                    </div>
                    <div class="stat-card__content">
                        <h3>2,845</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="stat-card__trend positive">
                        <x-icon icon="arrow-up" />
                        <span>12%</span>
                    </div>
                </div>

                <div class="stat-card bg--light">
                    <div class="vlx-icon--wrapper">
                        <x-icon icon="chart-bar" size="large" />
                    </div>
                    <div class="stat-card__content">
                        <h3>$8,492</h3>
                        <p>Total Revenue</p>
                    </div>
                    <div class="stat-card__trend positive">
                        <x-icon icon="arrow-up" />
                        <span>8.2%</span>
                    </div>
                </div>

                <div class="stat-card bg--light">
                    <div class="vlx-icon--wrapper">
                        <x-icon icon="cart-shopping" size="large" />
                    </div>
                    <div class="stat-card__content">
                        <h3>142</h3>
                        <p>New Orders</p>
                    </div>
                    <div class="stat-card__trend negative">
                        <x-icon icon="arrow-down" />
                        <span>3.8%</span>
                    </div>
                </div>

                <div class="stat-card bg--light">
                    <div class="vlx-icon--wrapper">
                        <x-icon icon="eye" size="large" />
                    </div>
                    <div class="stat-card__content">
                        <h3>28.6K</h3>
                        <p>Page Views</p>
                    </div>
                    <div class="stat-card__trend positive">
                        <x-icon icon="arrow-up" />
                        <span>14.2%</span>
                    </div>
                </div>
            </section>

            <section class="dashboard-widgets">
                <div class="widget span--2 bg--light">
                    <div class="widget__header">
                        <h3>Revenue Overview</h3>
                        <div class="widget__controls">
                            <button class="widget__control">
                                <x-icon icon="rotate-right" />
                            </button>
                            <button class="widget__control">
                                <x-icon icon="ellipsis-vertical" />
                            </button>
                        </div>
                    </div>
                    <div class="widget__content">
                        <div class="chart-placeholder">
                            <div class="chart-bar" style="height: 60%"></div>
                            <div class="chart-bar" style="height: 85%"></div>
                            <div class="chart-bar" style="height: 40%"></div>
                            <div class="chart-bar" style="height: 70%"></div>
                            <div class="chart-bar" style="height: 65%"></div>
                            <div class="chart-bar" style="height: 90%"></div>
                            <div class="chart-bar" style="height: 50%"></div>
                        </div>
                    </div>
                </div>

                <div class="widget span--2 bg--accent">
                    <div class="widget__header">
                        <h3>Recent Activities</h3>
                        <div class="widget__controls">
                            <button class="widget__control">
                                <x-icon icon="ellipsis-vertical" />
                            </button>
                        </div>
                    </div>
                    <div class="widget__content">
                        <ul class="activity-list">
                            <li class="activity-item">
                                <div class="activity-icon">
                                    <x-icon icon="user-plus" />
                                </div>
                                <div class="activity-content">
                                    <p>New user registered</p>
                                    <span class="activity-time">2 minutes ago</span>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon">
                                    <x-icon icon="cart-shopping" />
                                </div>
                                <div class="activity-content">
                                    <p>New order placed</p>
                                    <span class="activity-time">45 minutes ago</span>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon">
                                    <x-icon icon="credit-card" />
                                </div>
                                <div class="activity-content">
                                    <p>Payment received</p>
                                    <span class="activity-time">1 hour ago</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="dashboard-widgets">
                <div class="widget span--2">
                    <div class="widget__header">
                        <h3>Latest Users</h3>
                        <div class="widget__controls">
                            <button class="widget__control">
                                <x-icon icon="ellipsis-vertical" />
                            </button>
                        </div>
                    </div>
                    <div class="widget__content">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td>Today</td>
                                    <td>
                                        <button class="btn btn--small btn--primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                    <td>Yesterday</td>
                                    <td>
                                        <button class="btn btn--small btn--primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bob Johnson</td>
                                    <td>bob@example.com</td>
                                    <td>2 days ago</td>
                                    <td>
                                        <button class="btn btn--small btn--primary">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="widget span--2">
                    <div class="widget__header">
                        <h3>Upcoming Tasks</h3>
                        <div class="widget__controls">
                            <button class="widget__control">
                                <x-icon icon="plus" />
                            </button>
                            <button class="widget__control">
                                <x-icon icon="ellipsis-vertical" />
                            </button>
                        </div>
                    </div>
                    <div class="widget__content">
                        <ul class="task-list">
                            <li class="task-item">
                                <div class="task-checkbox">
                                    <input type="checkbox" id="task1">
                                    <label for="task1"></label>
                                </div>
                                <div class="task-content">
                                    <p>Review new project proposal</p>
                                    <span class="task-date">Due Today</span>
                                </div>
                                <div class="task-priority high">High</div>
                            </li>
                            <li class="task-item">
                                <div class="task-checkbox">
                                    <input type="checkbox" id="task2">
                                    <label for="task2"></label>
                                </div>
                                <div class="task-content">
                                    <p>Prepare monthly report</p>
                                    <span class="task-date">Due Tomorrow</span>
                                </div>
                                <div class="task-priority medium">Medium</div>
                            </li>
                            <li class="task-item">
                                <div class="task-checkbox">
                                    <input type="checkbox" id="task3">
                                    <label for="task3"></label>
                                </div>
                                <div class="task-content">
                                    <p>Team meeting</p>
                                    <span class="task-date">Next Friday</span>
                                </div>
                                <div class="task-priority low">Low</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </section>
</main>

@endsection
