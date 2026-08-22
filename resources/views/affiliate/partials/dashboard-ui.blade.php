@push('styles')
<style>
/* ═══ Affiliate Dashboard UI (Referrals, Commissions, Payouts) ═══ */
.aff-dash {
    min-height: 100vh;
    background: var(--bg2, #f8fafc);
    padding: 100px 20px 60px;
}

.aff-dash-wrap {
    max-width: 1200px;
    margin: 0 auto;
}

.aff-dash-header {
    margin-bottom: 32px;
}

.aff-back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ink4, #6b7280);
    text-decoration: none;
    margin-bottom: 16px;
    transition: color 0.2s;
}

.aff-back-link:hover {
    color: var(--primary, #ff4d1c);
}

.aff-dash-title {
    font-size: clamp(1.75rem, 4vw, 2.25rem);
    font-weight: 800;
    color: var(--ink, #111827);
    margin: 0 0 8px;
    letter-spacing: -0.02em;
}

.aff-dash-title em {
    font-style: normal;
    color: var(--primary, #ff4d1c);
}

.aff-dash-subtitle {
    font-size: 1.05rem;
    color: var(--ink4, #6b7280);
    margin: 0;
    max-width: 640px;
    line-height: 1.6;
}

.aff-dash-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 20px;
}

.aff-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 22px;
    border-radius: 10px;
    font-size: 0.938rem;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
}

.aff-btn:hover {
    transform: translateY(-1px);
}

.aff-btn-primary {
    background: linear-gradient(135deg, var(--primary, #ff4d1c), var(--primary-dark, #e63e10));
    color: #fff;
    box-shadow: 0 4px 14px rgba(255, 77, 28, 0.35);
}

.aff-btn-primary:hover {
    box-shadow: 0 6px 20px rgba(255, 77, 28, 0.45);
    color: #fff;
}

.aff-btn-outline {
    background: #fff;
    color: var(--ink, #111827);
    border: 1px solid var(--bg4, #e2e8f0);
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
}

.aff-btn-outline:hover {
    border-color: var(--primary, #ff4d1c);
    color: var(--primary, #ff4d1c);
}

/* Stats Grid */
.aff-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.aff-stat-card {
    background: #fff;
    border: 1px solid var(--bg4, #e2e8f0);
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    transition: box-shadow 0.2s, transform 0.2s;
}

.aff-stat-card:hover {
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    transform: translateY(-2px);
}

.aff-stat-top {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 14px;
}

.aff-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.aff-stat-icon i {
    font-size: 1.5rem;
}

.aff-stat-icon--orange { background: rgba(255, 77, 28, 0.1); color: #ff4d1c; }
.aff-stat-icon--green  { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.aff-stat-icon--blue   { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.aff-stat-icon--purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
.aff-stat-icon--amber  { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

.aff-stat-label {
    font-size: 0.813rem;
    font-weight: 600;
    color: var(--ink4, #6b7280);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.aff-stat-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--ink, #111827);
    line-height: 1.2;
    letter-spacing: -0.02em;
}

/* Alert */
.aff-alert {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 18px 22px;
    background: rgba(245, 158, 11, 0.08);
    border: 1px solid rgba(245, 158, 11, 0.25);
    border-radius: 14px;
    margin-bottom: 32px;
}

.aff-alert-icon {
    width: 44px;
    height: 44px;
    background: rgba(245, 158, 11, 0.15);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.aff-alert-icon i {
    font-size: 1.35rem;
    color: #f59e0b;
}

.aff-alert-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--ink, #111827);
    margin: 0 0 4px;
}

.aff-alert-text {
    font-size: 0.938rem;
    color: var(--ink3, #374151);
    margin: 0;
    line-height: 1.5;
}

/* Panel */
.aff-panel {
    background: #fff;
    border: 1px solid var(--bg4, #e2e8f0);
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    overflow: hidden;
}

.aff-panel-head {
    padding: 28px 28px 0;
}

.aff-panel-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--ink, #111827);
    margin: 0 0 6px;
}

.aff-panel-title em {
    font-style: normal;
    color: var(--primary, #ff4d1c);
}

.aff-panel-desc {
    font-size: 0.938rem;
    color: var(--ink4, #6b7280);
    margin: 0 0 24px;
}

/* Table */
.aff-table-wrap {
    overflow-x: auto;
}

.aff-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 640px;
}

.aff-table thead {
    background: var(--bg2, #f8fafc);
}

.aff-table th {
    padding: 14px 24px;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--ink4, #6b7280);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid var(--bg4, #e2e8f0);
}

.aff-table td {
    padding: 16px 24px;
    vertical-align: middle;
    border-bottom: 1px solid var(--bg3, #f1f5f9);
    font-size: 0.938rem;
    color: var(--ink2, #1f2937);
}

.aff-table tbody tr:last-child td {
    border-bottom: none;
}

.aff-table tbody tr:hover {
    background: var(--bg2, #f8fafc);
}

.aff-date-main {
    display: block;
    font-weight: 600;
    color: var(--ink, #111827);
}

.aff-date-sub {
    display: block;
    font-size: 0.813rem;
    color: var(--ink5, #9ca3af);
    margin-top: 2px;
}

.aff-user {
    display: flex;
    align-items: center;
    gap: 12px;
}

.aff-user-avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary, #ff4d1c), var(--primary-dark, #e63e10));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.aff-user-avatar i {
    font-size: 1.25rem;
    color: #fff;
}

.aff-user-name {
    display: block;
    font-weight: 700;
    color: var(--ink, #111827);
}

.aff-user-email {
    display: block;
    font-size: 0.813rem;
    color: var(--ink5, #9ca3af);
}

.aff-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.813rem;
    font-weight: 600;
}

.aff-badge--success { background: #d1fae5; color: #065f46; }
.aff-badge--pending { background: #fef3c7; color: #92400e; }
.aff-badge--info    { background: #dbeafe; color: #1e40af; }
.aff-badge--danger  { background: #fee2e2; color: #991b1b; }
.aff-badge--muted   { background: var(--bg3, #f1f5f9); color: var(--ink3, #374151); }

.aff-amount {
    font-size: 1.125rem;
    font-weight: 800;
    color: var(--primary, #ff4d1c);
}

.aff-code {
    font-family: ui-monospace, monospace;
    font-size: 0.813rem;
    font-weight: 600;
    background: var(--bg3, #f1f5f9);
    padding: 4px 10px;
    border-radius: 6px;
    color: var(--ink3, #374151);
}

.aff-muted {
    color: var(--ink5, #9ca3af);
}

.aff-pagination {
    padding: 20px 24px;
    border-top: 1px solid var(--bg4, #e2e8f0);
    background: var(--bg2, #f8fafc);
}

/* Empty State */
.aff-empty {
    text-align: center;
    padding: 64px 32px;
}

.aff-empty-icon {
    width: 96px;
    height: 96px;
    margin: 0 auto 24px;
    background: var(--primary-soft, rgba(255, 77, 28, 0.07));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.aff-empty-icon i {
    font-size: 2.75rem;
    color: var(--primary, #ff4d1c);
}

.aff-empty-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--ink, #111827);
    margin: 0 0 10px;
}

.aff-empty-text {
    font-size: 1rem;
    color: var(--ink4, #6b7280);
    margin: 0 auto 24px;
    max-width: 420px;
    line-height: 1.6;
}

@media (max-width: 992px) {
    .aff-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .aff-dash {
        padding: 88px 16px 40px;
    }

    .aff-stats-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .aff-stat-card {
        padding: 18px;
    }

    .aff-stat-value {
        font-size: 1.5rem;
    }

    .aff-panel-head {
        padding: 20px 20px 0;
    }

    .aff-table th,
    .aff-table td {
        padding: 12px 16px;
    }

    .aff-empty {
        padding: 48px 20px;
    }

    .aff-alert {
        flex-direction: column;
    }
}
</style>
@endpush
