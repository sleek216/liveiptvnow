@extends('layouts.app')

@section('title', 'Secret Dashboard')

@section('content')
<section class="custom-dashboard-section">
    <div class="container">
        <div class="dashboard-header" data-aos="fade-down">
            <h1 class="dashboard-title">
                <i class="ph-fill ph-rocket-launch text-primary"></i> 
                Secret Dashboard
            </h1>
            <p class="dashboard-subtitle">A highly customized hidden portal tailored exclusively for you.</p>
        </div>

        <div class="dashboard-grid">
            <!-- Stats Cards -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon">
                    <i class="ph-fill ph-users"></i>
                </div>
                <div class="stat-details">
                    <h3>Active Users</h3>
                    <p class="stat-number">1,248</p>
                    <span class="stat-trend positive"><i class="ph-bold ph-arrow-up-right"></i> +12% this week</span>
                </div>
            </div>

            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon" style="color: #ec4899; background: rgba(236, 72, 153, 0.12);">
                    <i class="ph-fill ph-chart-line-up"></i>
                </div>
                <div class="stat-details">
                    <h3>Revenue</h3>
                    <p class="stat-number">$34,500</p>
                    <span class="stat-trend positive"><i class="ph-bold ph-arrow-up-right"></i> +8% this week</span>
                </div>
            </div>

            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon" style="color: #06b6d4; background: rgba(6, 182, 212, 0.12);">
                    <i class="ph-fill ph-activity"></i>
                </div>
                <div class="stat-details">
                    <h3>System Load</h3>
                    <p class="stat-number">24%</p>
                    <span class="stat-trend neutral"><i class="ph-bold ph-minus"></i> Stable</span>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="dashboard-main" data-aos="fade-up" data-aos-delay="400">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Recent Activities</h2>
                        <button class="btn-icon"><i class="ph-bold ph-dots-three"></i></button>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon success"><i class="ph-fill ph-check-circle"></i></div>
                            <div class="activity-text">
                                <strong>System updated</strong> successfully to version 4.2.0
                                <span class="activity-time">2 hours ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon warning"><i class="ph-fill ph-warning-circle"></i></div>
                            <div class="activity-text">
                                <strong>High CPU usage</strong> detected on server Alpha
                                <span class="activity-time">5 hours ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon info"><i class="ph-fill ph-user-plus"></i></div>
                            <div class="activity-text">
                                <strong>New user registration</strong> spike detected
                                <span class="activity-time">Yesterday</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Content -->
            <div class="dashboard-sidebar" data-aos="fade-left" data-aos-delay="500">
                <div class="dashboard-card quick-actions">
                    <div class="card-header">
                        <h2>Quick Actions</h2>
                    </div>
                    <div class="actions-grid">
                        <button class="action-btn">
                            <i class="ph-fill ph-file-text"></i>
                            <span>Reports</span>
                        </button>
                        <button class="action-btn">
                            <i class="ph-fill ph-gear"></i>
                            <span>Settings</span>
                        </button>
                        <button class="action-btn">
                            <i class="ph-fill ph-bell"></i>
                            <span>Alerts</span>
                        </button>
                        <button class="action-btn">
                            <i class="ph-fill ph-shield-check"></i>
                            <span>Security</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Premium Dark Cinematic Dashboard Theme */
    .custom-dashboard-section {
        --primary-color: #7c3aed;
        --secondary-color: #db2777;
        --bg-dark: #020408;
        --bg-card: rgba(255, 255, 255, 0.03);
        --text-main: #ffffff;
        --text-muted: #94a3b8;
        --border-color: rgba(255, 255, 255, 0.08);
        
        padding: 120px 0 80px;
        min-height: 100vh;
        background: radial-gradient(ellipse at top right, rgba(124, 58, 237, 0.15), transparent 60%),
                    radial-gradient(ellipse at bottom left, rgba(219, 39, 119, 0.15), transparent 60%),
                    linear-gradient(180deg, var(--bg-dark) 0%, #0b0618 100%);
        color: var(--text-main);
        font-family: 'Inter', system-ui, sans-serif;
    }

    .dashboard-header {
        margin-bottom: 3rem;
        text-align: center;
    }

    .dashboard-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, #fff, #cbd5e1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .dashboard-subtitle {
        color: var(--text-muted);
        font-size: 1.125rem;
    }

    .text-primary {
        color: var(--primary-color);
        -webkit-text-fill-color: var(--primary-color);
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        backdrop-filter: blur(12px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        background: rgba(124, 58, 237, 0.12);
        color: var(--primary-color);
    }

    .stat-details h3 {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-trend {
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stat-trend.positive { color: #10b981; }
    .stat-trend.negative { color: #ef4444; }
    .stat-trend.neutral { color: #64748b; }

    .dashboard-main {
        grid-column: span 2;
    }

    .dashboard-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 2rem;
        backdrop-filter: blur(12px);
        height: 100%;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .card-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .btn-icon {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .btn-icon:hover {
        color: var(--text-main);
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .activity-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .activity-icon.success { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .activity-icon.warning { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .activity-icon.info { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }

    .activity-text {
        font-size: 0.9375rem;
        color: #cbd5e1;
        line-height: 1.5;
    }

    .activity-text strong {
        color: #fff;
    }

    .activity-time {
        display: block;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .action-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-main);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-btn i {
        font-size: 2rem;
        color: var(--text-muted);
        transition: color 0.3s ease;
    }

    .action-btn:hover {
        background: rgba(124, 58, 237, 0.15);
        border-color: rgba(124, 58, 237, 0.4);
        transform: translateY(-2px);
    }

    .action-btn:hover i {
        color: var(--primary-color);
    }

    @media (max-width: 992px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
        .dashboard-main {
            grid-column: span 1;
        }
    }
</style>
@endpush
