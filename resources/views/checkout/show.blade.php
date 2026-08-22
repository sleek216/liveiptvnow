@extends('layouts.app')

@section('title', 'Checkout - ' . $package->name . ' - Live IPTV Now')

@push('styles')
<style>
/* ═══════════════════════════════════════
   CHECKOUT PAGE — Premium Light Theme
   ═══════════════════════════════════════ */
.co-page {
    min-height: 100vh;
    background: var(--bg2);
    padding: 140px 0 80px;
    position: relative;
    overflow: hidden;
}

.co-page::before {
    content: '';
    position: absolute;
    top: -200px;
    left: -200px;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(255,77,28,0.05) 0%, transparent 70%);
    pointer-events: none;
}

.co-page::after {
    content: '';
    position: absolute;
    bottom: -100px;
    right: -100px;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(59,130,246,0.03) 0%, transparent 70%);
    pointer-events: none;
}

.co-wrap {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 1;
}

/* ── Breadcrumb ── */
.co-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 36px;
}

.co-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--ink3);
    font-size: 0.875rem;
    font-weight: 640;
    padding: 8px 16px;
    border-radius: 10px;
    border: var(--bdr);
    background: #fff;
    transition: var(--t);
    box-shadow: var(--s1);
}

.co-back:hover {
    color: var(--primary);
    border-color: var(--primary);
    background: var(--primary-soft);
    transform: translateX(-3px);
}

.co-back i { font-size: 1rem; }

/* ── Page Title ── */
.co-title-block {
    margin-bottom: 40px;
}

.co-title-block h1 {
    font-size: clamp(1.75rem, 4vw, 2.4rem);
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.5px;
    margin-bottom: 8px;
}

.co-title-block p {
    color: var(--ink4);
    font-size: 0.9375rem;
}

/* ── 3-Step Progress ── */
.co-steps {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 40px;
}

.co-step {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

.co-step-num {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 800;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.co-step.done .co-step-num {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 0 0 4px rgba(255,77,28,0.15);
}

.co-step.active .co-step-num {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 0 0 4px rgba(255,77,28,0.15);
}

.co-step.inactive .co-step-num {
    background: #fff;
    color: var(--ink5);
    border: var(--bdr);
}

.co-step-label {
    font-size: 0.8125rem;
    font-weight: 700;
    color: var(--ink4);
}

.co-step.active .co-step-label,
.co-step.done .co-step-label {
    color: var(--ink);
}

.co-step-line {
    flex: 1;
    height: 2px;
    background: var(--bg3);
    margin: 0 12px;
}

.co-step-line.done {
    background: var(--primary);
}

/* ── Grid Layout ── */
.co-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 28px;
    align-items: start;
}

/* ── Card ── */
.co-card {
    background: #fff;
    border: var(--bdr);
    border-radius: 20px;
    padding: 32px;
    box-shadow: var(--s2);
}

/* ── Section Headers ── */
.co-sec-hd {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: var(--bdr);
}

.co-sec-ic {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.125rem;
    flex-shrink: 0;
}

.co-sec-hd-txt h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 2px;
}

.co-sec-hd-txt p {
    font-size: 0.8rem;
    color: var(--ink4);
}

/* ── Form Sections ── */
.co-form-sec {
    margin-bottom: 28px;
    padding-bottom: 28px;
    border-bottom: 1px solid var(--bg3);
}

.co-form-sec:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.co-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.co-field {
    margin-bottom: 16px;
}

.co-field label {
    display: block;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--ink2);
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.co-field label .req {
    color: var(--primary);
}

.co-field input,
.co-field textarea,
.co-field select {
    width: 100%;
    padding: 13px 16px;
    font-size: 0.9375rem;
    color: var(--ink);
    background: var(--bg2);
    border: var(--bdr);
    border-radius: 12px;
    font-family: var(--font);
    transition: var(--t);
    outline: none;
}

.co-field input::placeholder,
.co-field textarea::placeholder {
    color: var(--ink5);
}

.co-field input:focus,
.co-field textarea:focus,
.co-field select:focus {
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 3px var(--primary-glow);
}

.co-field select option {
    background: #fff;
    color: var(--ink);
}

.co-hint {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 6px;
    font-size: 0.78rem;
    color: var(--ink4);
}

.co-hint i { font-size: 0.85rem; }

.co-field-err {
    display: block;
    margin-top: 6px;
    font-size: 0.78rem;
    color: var(--error);
}

/* ── Alerts ── */
.co-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 0.875rem;
}

.co-alert i { font-size: 1.1rem; flex-shrink: 0; margin-top: 1px; }

.co-alert-err {
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.2);
    color: var(--error);
}

.co-alert-ok {
    background: rgba(16,185,129,0.08);
    border: 1px solid rgba(16,185,129,0.2);
    color: var(--success);
}

.co-alert-warn {
    background: rgba(245,158,11,0.08);
    border: 1px solid rgba(245,158,11,0.2);
    color: var(--warning);
}

/* ── Country Grid ── */
.co-countries {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 10px;
}

.co-country-lbl {
    cursor: pointer;
}

.co-country-lbl input { display: none; }

.co-country-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 14px 10px;
    background: var(--bg2);
    border: var(--bdr);
    border-radius: 14px;
    position: relative;
    text-align: center;
    transition: var(--t);
}

.co-country-lbl:hover .co-country-card {
    border-color: var(--primary);
    background: var(--primary-soft);
}

.co-country-lbl input:checked + .co-country-card {
    border-color: var(--primary);
    background: var(--primary-soft);
    box-shadow: 0 0 0 1px var(--primary-glow);
}

.co-flag { font-size: 1.75rem; line-height: 1; }

.co-cname {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--ink3);
    line-height: 1.2;
}

.co-country-lbl input:checked + .co-country-card .co-cname {
    color: var(--ink);
}

.co-ctick {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--bg3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    color: transparent;
    transition: all 0.2s ease;
}

.co-country-lbl input:checked + .co-country-card .co-ctick {
    background: var(--primary);
    color: #fff;
}

/* ── Payment Options ── */
.co-payments {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.co-pay-lbl { cursor: pointer; }
.co-pay-lbl input { display: none; }

.co-pay-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    background: var(--bg2);
    border: var(--bdr);
    border-radius: 14px;
    transition: var(--t);
}

.co-pay-lbl:hover .co-pay-card {
    border-color: var(--primary);
    background: var(--primary-soft);
}

.co-pay-lbl input:checked + .co-pay-card {
    border-color: var(--primary);
    background: var(--primary-soft);
}

.co-pay-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: #fff;
    border: var(--bdr);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: var(--ink3);
    flex-shrink: 0;
    transition: var(--t);
}

.co-pay-lbl input:checked + .co-pay-card .co-pay-icon {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

.co-pay-info { flex: 1; }

.co-pay-name {
    display: block;
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 2px;
}

.co-pay-desc {
    font-size: 0.78rem;
    color: var(--ink4);
}

.co-pay-radio {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid var(--ink5);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.co-pay-radio::after {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--primary);
    opacity: 0;
    transform: scale(0);
    transition: all 0.2s ease;
}

.co-pay-lbl input:checked + .co-pay-card .co-pay-radio {
    border-color: var(--primary);
}

.co-pay-lbl input:checked + .co-pay-card .co-pay-radio::after {
    opacity: 1;
    transform: scale(1);
}

/* ── Terms Checkbox ── */
.co-terms {
    margin-bottom: 24px;
}

.co-chk-wrap {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--ink3);
}

.co-chk-wrap input { display: none; }

.co-chkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--ink5);
    border-radius: 6px;
    flex-shrink: 0;
    position: relative;
    transition: all 0.2s ease;
    margin-top: 1px;
}

.co-chk-wrap input:checked + .co-chkmark {
    background: var(--primary);
    border-color: var(--primary);
}

.co-chk-wrap input:checked + .co-chkmark::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 1px;
    width: 5px;
    height: 10px;
    border: solid #fff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.co-chk-wrap a {
    color: var(--primary);
    text-decoration: underline;
    text-underline-offset: 3px;
    font-weight: 600;
}

/* ── Submit Button ── */
.co-submit {
    width: 100%;
    padding: 17px 24px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: #fff;
    border: none;
    border-radius: 14px;
    font-family: var(--font);
    font-size: 1rem;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 16px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--s-primary);
    letter-spacing: 0.3px;
}

.co-submit::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s ease;
}

.co-submit:hover::before { left: 100%; }

.co-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(255,77,28,0.4);
}

.co-submit:active { transform: translateY(0); }

/* ── Secure Badge ── */
.co-secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.78rem;
    color: var(--ink4);
}

.co-secure i { color: var(--success); font-size: 0.9rem; }

/* ════════════════════════════════
   ORDER SUMMARY SIDEBAR
   ════════════════════════════════ */
.co-sidebar {
    position: sticky;
    top: 140px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* ── Package Card ── */
.co-pkg {
    background: #fff;
    border: var(--bdr);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--s2);
}

.co-pkg-top {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 20px 24px;
    position: relative;
}

.co-pkg-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    background: rgba(255,255,255,0.2);
    color: #fff;
    font-size: 0.68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 99px;
    margin-bottom: 12px;
}

.co-pkg-name {
    font-size: 1.375rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 4px;
}

.co-pkg-meta {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.8);
    display: flex;
    align-items: center;
    gap: 8px;
}

.co-pkg-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.co-pkg-body {
    padding: 20px 24px;
}

.co-feat-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.co-feat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.875rem;
    color: var(--ink);
}

.co-feat-ic {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(16,185,129,0.1);
    border: 1px solid rgba(16,185,129,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--success);
    font-size: 0.7rem;
}

/* ── Coupon ── */
.co-coupon {
    padding: 20px 24px;
    border-top: 1px solid var(--bg3);
}

.co-coupon-label {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--ink4);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.co-coupon-row {
    display: flex;
    gap: 8px;
}

.co-coupon-input {
    flex: 1;
    padding: 11px 14px;
    background: var(--bg2);
    border: var(--bdr);
    border-radius: 10px;
    color: var(--ink);
    font-family: var(--font);
    font-size: 0.875rem;
    outline: none;
    transition: var(--t);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.co-coupon-input::placeholder {
    text-transform: none;
    letter-spacing: 0;
    color: var(--ink5);
}

.co-coupon-input:focus {
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 3px var(--primary-glow);
}

.co-coupon-btn {
    padding: 11px 18px;
    background: #fff;
    border: 1px solid var(--primary);
    border-radius: 10px;
    color: var(--primary);
    font-family: var(--font);
    font-size: 0.8125rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--t);
    white-space: nowrap;
}

.co-coupon-btn:hover {
    background: var(--primary);
    color: #fff;
}

.co-coupon-msg {
    margin-top: 8px;
    font-size: 0.78rem;
}

/* ── Price Breakdown ── */
.co-price-block {
    padding: 20px 24px;
    border-top: 1px solid var(--bg3);
}

.co-price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 0.875rem;
    color: var(--ink3);
}


/* ── Price Breakdown ── */
.co-price-block {
    padding: 20px 24px;
    border-top: 1px solid var(--bg3);
}

.co-price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 0.875rem;
    color: var(--ink3);
    border-bottom: 1px dashed var(--bg3);
}

.co-price-row:last-child { border-bottom: none; }

.co-price-row .strike {
    text-decoration: line-through;
    color: var(--ink5);
}

.co-price-row.co-disc {
    color: var(--success);
}

.co-price-row.co-total {
    padding-top: 14px;
    margin-top: 6px;
    border-top: 1px solid var(--bg3);
    border-bottom: none;
}

.co-total-l {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--ink);
}

.co-total-r {
    font-size: 1.625rem;
    font-weight: 900;
    color: var(--primary);
    letter-spacing: -0.5px;
}

/* ── Guarantee ── */
.co-guarantee {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px;
    background: rgba(16,185,129,0.08);
    border: 1px solid rgba(16,185,129,0.2);
    border-radius: 16px;
}

.co-guar-ic {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(16,185,129,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--success);
    font-size: 1.3rem;
    flex-shrink: 0;
}

.co-guar-txt strong {
    display: block;
    font-size: 0.875rem;
    color: var(--success);
    margin-bottom: 2px;
}

.co-guar-txt span {
    font-size: 0.78rem;
    color: var(--ink4);
}

/* ── Support Box ── */
.co-support {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px;
    background: var(--bg2);
    border: var(--bdr);
    border-radius: 16px;
}

.co-sup-ic {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--primary-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.3rem;
    flex-shrink: 0;
}

.co-sup-txt { flex: 1; }

.co-sup-txt strong {
    display: block;
    font-size: 0.875rem;
    color: var(--ink);
    margin-bottom: 2px;
}

.co-sup-txt span {
    font-size: 0.78rem;
    color: var(--ink4);
}

.co-sup-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    border-radius: 9px;
    color: var(--primary);
    font-family: var(--font);
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--t);
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
}

.co-sup-btn:hover {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

/* ── Referral Section ── */
.co-referral-hint {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 16px;
    background: rgba(59,130,246,0.08);
    border: 1px solid rgba(59,130,246,0.18);
    border-radius: 10px;
    margin-top: 10px;
    font-size: 0.78rem;
    color: rgba(147,197,253,0.8);
}

.co-referral-hint i { color: #60a5fa; font-size: 0.9rem; flex-shrink: 0; margin-top: 1px; }

/* ── Payment Modal ── */
.co-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(4px);
    padding: 24px;
}

.co-modal.is-active {
    opacity: 1;
    visibility: visible;
}

.co-modal-box {
    background: #fff;
    border: var(--bdr);
    border-radius: 24px;
    padding: 40px 36px;
    width: 100%;
    max-width: 440px;
    text-align: center;
    transform: translateY(24px) scale(0.97);
    transition: all 0.3s ease;
    position: relative;
    box-shadow: var(--s4);
}

.co-modal.is-active .co-modal-box {
    transform: translateY(0) scale(1);
}

.co-modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--bg2);
    border: var(--bdr);
    color: var(--ink4);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s;
}

.co-modal-close:hover { background: var(--error); color: #fff; }

.co-modal-ic {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: var(--primary-soft);
    border: 1px solid var(--primary-glow);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 2rem;
    margin: 0 auto 20px;
}

.co-modal-box h3 {
    font-size: 1.375rem;
    color: var(--ink);
    margin-bottom: 10px;
}

.co-modal-box p {
    font-size: 0.875rem;
    color: var(--ink4);
    line-height: 1.6;
    margin-bottom: 28px;
}

.co-modal-btns {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.co-modal-btns .btn-prim {
    padding: 14px;
    background: linear-gradient(135deg, var(--primary) 0%, #e63e10 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-family: var(--font);
    font-size: 0.9375rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.22s ease;
}

.co-modal-btns .btn-prim:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(255,77,28,0.3); }

.co-modal-btns .btn-ghost {
    padding: 13px;
    background: transparent;
    color: var(--ink4);
    border: var(--bdr);
    border-radius: 12px;
    font-family: var(--font);
    font-size: 0.875rem;
    cursor: pointer;
    transition: var(--t);
}

.co-modal-btns .btn-ghost:hover { color: var(--ink); border-color: var(--ink5); }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .co-grid {
        grid-template-columns: 1fr;
    }
    .co-sidebar {
        position: static;
        order: -1;
    }
    .co-pkg .co-pkg-body,
    .co-pkg .co-coupon,
    .co-pkg .co-price-block {
        display: none;
    }
    .co-pkg-summary-only { display: block !important; }
}

@media (max-width: 768px) {
    .co-page { padding: 120px 0 60px; }
    .co-card { padding: 22px 18px; }
    .co-row { grid-template-columns: 1fr; }
    .co-steps { display: none; }
    .co-title-block h1 { font-size: 1.625rem; }
}
</style>
@endpush

@section('content')
<section class="co-page">
    <div class="co-wrap">

        {{-- Back Link --}}
        <div class="co-breadcrumb">
            <a href="{{ route('packages.index') }}" class="co-back">
                <i class="ri-arrow-left-line"></i> Back to Plans
            </a>
        </div>

        {{-- Title --}}
        <div class="co-title-block">
            <h1>Secure Checkout</h1>
            <p>Complete your purchase in seconds — instant activation after payment</p>
        </div>

        {{-- Progress Steps --}}
        <div class="co-steps">
            <div class="co-step done">
                <div class="co-step-num"><i class="ri-check-line"></i></div>
                <div class="co-step-label">Choose Plan</div>
            </div>
            <div class="co-step-line done"></div>
            <div class="co-step active">
                <div class="co-step-num">2</div>
                <div class="co-step-label">Your Details</div>
            </div>
            <div class="co-step-line"></div>
            <div class="co-step inactive">
                <div class="co-step-num">3</div>
                <div class="co-step-label">Confirmation</div>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="co-alert co-alert-ok"><i class="ri-checkbox-circle-fill"></i><span>{{ session('success') }}</span></div>
        @endif
        @if(session('error'))
        <div class="co-alert co-alert-err"><i class="ri-close-circle-fill"></i><span>{{ session('error') }}</span></div>
        @endif
        @if($errors->any())
        <div class="co-alert co-alert-err">
            <i class="ri-close-circle-fill"></i>
            <span>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </span>
        </div>
        @endif

        {{-- Main Grid --}}
        <div class="co-grid">

            {{-- ══ LEFT: FORM ══ --}}
            <div>
                <form action="{{ route('checkout.process', $package->slug) }}" method="POST" id="co-form">
                    @csrf

                    {{-- Personal Info --}}
                    <div class="co-card" style="margin-bottom:20px;" data-aos="fade-up">
                        <div class="co-sec-hd">
                            <div class="co-sec-ic"><i class="ri-user-fill"></i></div>
                            <div class="co-sec-hd-txt">
                                <h3>Personal Information</h3>
                                <p>Your subscription will be sent to these details</p>
                            </div>
                        </div>

                        <div class="co-field">
                            <label>Full Name <span class="req">*</span></label>
                            <input type="text" name="customer_name" id="customer_name"
                                value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                                placeholder="Enter your full name" required>
                            @error('customer_name')<span class="co-field-err">{{ $message }}</span>@enderror
                        </div>

                        <div class="co-row">
                            <div class="co-field">
                                <label>Email Address <span class="req">*</span></label>
                                <input type="email" name="customer_email" id="customer_email"
                                    value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                    placeholder="you@email.com" required>
                                <span class="co-hint"><i class="ri-mail-line"></i> Activation details sent here</span>
                                @error('customer_email')<span class="co-field-err">{{ $message }}</span>@enderror
                            </div>
                            <div class="co-field">
                                <label>Phone Number <span style="color:var(--ink5);font-weight:400;">(Optional)</span></label>
                                <input type="tel" name="customer_phone" id="customer_phone"
                                    value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                                    placeholder="+1 (555) 123-4567">
                            </div>
                        </div>
                    </div>

                    {{-- Countries --}}
                    @if($countries && $countries->count() > 0)
                    <div class="co-card" style="margin-bottom:20px;" data-aos="fade-up" data-aos-delay="50">
                        <div class="co-sec-hd">
                            <div class="co-sec-ic"><i class="ri-global-fill"></i></div>
                            <div class="co-sec-hd-txt">
                                <h3>Select Countries / Regions</h3>
                                <p>Pick the countries you want channels from</p>
                            </div>
                        </div>
                        <div class="co-countries">
                            @foreach($countries as $country)
                            <label class="co-country-lbl">
                                <input type="checkbox" name="selected_countries[]" value="{{ $country->id }}"
                                    {{ in_array($country->id, old('selected_countries', [])) ? 'checked' : '' }}>
                                <div class="co-country-card">
                                    <span class="co-flag">{{ $country->flag }}</span>
                                    <span class="co-cname">{{ $country->name }}</span>
                                    <div class="co-ctick"><i class="ri-check-fill"></i></div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('selected_countries')
                        <span class="co-field-err" style="margin-top:10px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif

                    {{-- Notes --}}
                    <div class="co-card" style="margin-bottom:20px;" data-aos="fade-up" data-aos-delay="80">
                        <div class="co-sec-hd">
                            <div class="co-sec-ic"><i class="ri-edit-2-fill"></i></div>
                            <div class="co-sec-hd-txt">
                                <h3>Special Instructions</h3>
                                <p>Optional — any device info or requirements</p>
                            </div>
                        </div>
                        <div class="co-field" style="margin-bottom:0;">
                            <textarea name="notes" id="notes" rows="3"
                                placeholder="e.g. Firestick 4K, Samsung Smart TV, specific channel requests...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    {{-- Referral Code --}}
                    <div class="co-card" style="margin-bottom:20px;" data-aos="fade-up" data-aos-delay="100">
                        <div class="co-sec-hd">
                            <div class="co-sec-ic"><i class="ri-gift-fill"></i></div>
                            <div class="co-sec-hd-txt">
                                <h3>Referral Code</h3>
                                <p>Have a friend's code? Enter it to support them</p>
                            </div>
                        </div>
                        <div class="co-field" style="margin-bottom:0;">
                            <input type="text" name="referral_code" id="referral_code"
                                value="{{ $referralCodePrefill ?? old('referral_code') }}"
                                placeholder="e.g. ABC12345"
                                maxlength="20"
                                style="text-transform:uppercase;letter-spacing:2px;">
                            <div class="co-referral-hint">
                                <i class="ri-information-line"></i>
                                <span>This is optional. Entering a friend's referral code helps them earn commission — it does not affect your price.</span>
                            </div>
                            @error('referral_code')<span class="co-field-err">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="co-card" data-aos="fade-up" data-aos-delay="120">
                        <div class="co-sec-hd">
                            <div class="co-sec-ic"><i class="ri-bank-card-fill"></i></div>
                            <div class="co-sec-hd-txt">
                                <h3>Payment Method</h3>
                                <p>Choose how you'd like to pay</p>
                            </div>
                        </div>

                        @php
                            $stripeEnabled = \App\Models\Setting::get('stripe_enabled', '1') === '1';
                            $cryptoEnabled = \App\Models\Setting::get('nowpayments_enabled', '0') === '1';
                            $defaultMethod = $stripeEnabled ? 'stripe' : ($cryptoEnabled ? 'crypto' : '');
                        @endphp

                        @if(!$stripeEnabled && !$cryptoEnabled)
                        <div class="co-alert co-alert-warn">
                            <i class="ri-error-warning-fill"></i>
                            <span>No payment methods are currently available. Please contact support.</span>
                        </div>
                        @else
                        <div class="co-payments">
                            @if($stripeEnabled)
                            <label class="co-pay-lbl">
                                <input type="radio" name="payment_method" value="stripe"
                                    {{ old('payment_method', $defaultMethod) == 'stripe' ? 'checked' : '' }}>
                                <div class="co-pay-card">
                                    <div class="co-pay-icon" style="color:#635bff;"><i class="ri-bank-card-fill"></i></div>
                                    <div class="co-pay-info">
                                        <span class="co-pay-name">Credit / Debit Card</span>
                                        <span class="co-pay-desc">Visa, Mastercard, American Express</span>
                                    </div>
                                    <div class="co-pay-radio"></div>
                                </div>
                            </label>
                            @endif

                            @if($cryptoEnabled)
                            <label class="co-pay-lbl">
                                <input type="radio" name="payment_method" value="crypto"
                                    {{ old('payment_method', $defaultMethod) == 'crypto' ? 'checked' : '' }}>
                                <div class="co-pay-card">
                                    <div class="co-pay-icon" style="color:#f7931a;"><i class="ri-bitcoin-fill"></i></div>
                                    <div class="co-pay-info">
                                        <span class="co-pay-name">Cryptocurrency</span>
                                        <span class="co-pay-desc">Bitcoin, Ethereum, USDT &amp; more</span>
                                    </div>
                                    <div class="co-pay-radio"></div>
                                </div>
                            </label>
                            @endif
                        </div>
                        @endif

                        @error('payment_method')
                        <span class="co-field-err" style="margin-top:10px;display:block;">{{ $message }}</span>
                        @enderror

                        {{-- Crypto Currency Picker --}}
                        <div id="crypto-currency-section" style="display:none;margin-top:18px;">
                            <div class="co-field" style="margin-bottom:0;">
                                <label>Select Cryptocurrency</label>
                                <select name="crypto_currency" id="crypto_currency">
                                    <option value="">Choose a currency...</option>
                                    <option value="btc"  {{ old('crypto_currency') == 'btc'  ? 'selected' : '' }}>Bitcoin (BTC)</option>
                                    <option value="eth"  {{ old('crypto_currency') == 'eth'  ? 'selected' : '' }}>Ethereum (ETH)</option>
                                    <option value="usdt" {{ old('crypto_currency') == 'usdt' ? 'selected' : '' }}>Tether (USDT)</option>
                                    <option value="ltc"  {{ old('crypto_currency') == 'ltc'  ? 'selected' : '' }}>Litecoin (LTC)</option>
                                    <option value="bnb"  {{ old('crypto_currency') == 'bnb'  ? 'selected' : '' }}>Binance Coin (BNB)</option>
                                    <option value="trx"  {{ old('crypto_currency') == 'trx'  ? 'selected' : '' }}>TRON (TRX)</option>
                                    <option value="xrp"  {{ old('crypto_currency') == 'xrp'  ? 'selected' : '' }}>Ripple (XRP)</option>
                                </select>
                                @error('crypto_currency')<span class="co-field-err">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Terms --}}
                        <div class="co-terms" style="margin-top:24px;">
                            <label class="co-chk-wrap">
                                <input type="checkbox" required>
                                <span class="co-chkmark"></span>
                                <span>I agree to the <a href="{{ route('terms') }}">Terms of Service</a> and <a href="{{ route('privacy') }}">Privacy Policy</a></span>
                            </label>
                        </div>

                        <button type="submit" class="co-submit" id="co-submit-btn">
                            <i class="ri-lock-2-fill"></i>
                            Complete Purchase — ${{ number_format($package->price, 2) }}
                        </button>

                        <div class="co-secure">
                            <i class="ri-shield-check-fill"></i>
                            <span>256-bit SSL encrypted &amp; secure</span>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ══ RIGHT: SIDEBAR ══ --}}
            <div class="co-sidebar" data-aos="fade-left">

                {{-- Package Summary --}}
                <div class="co-pkg">
                    <div class="co-pkg-top">
                        @if($package->is_popular)
                        <div class="co-pkg-badge"><i class="ri-vip-crown-fill"></i> Most Popular</div>
                        @endif
                        <div class="co-pkg-name">{{ $package->name }}</div>
                        <div class="co-pkg-meta">
                            <span><i class="ri-time-line"></i> {{ $package->duration_label }}</span>
                            <span>•</span>
                            <span><i class="ri-tv-2-line"></i> {{ $package->devices }} {{ $package->devices > 1 ? 'Devices' : 'Device' }}</span>
                        </div>
                    </div>

                    <div class="co-pkg-body">
                        <div class="co-feat-list">
                            @foreach([
                                '20,000+ Channels &amp; VOD',
                                'HD &amp; 4K Image Quality',
                                'TV Guide (EPG)',
                                'Anti-Freeze Technology',
                                'Instant Activation',
                                '24/7 Customer Support'
                            ] as $feat)
                            <div class="co-feat-item">
                                <div class="co-feat-ic"><i class="ri-check-fill"></i></div>
                                <span>{!! $feat !!}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Coupon --}}
                    <div class="co-coupon">
                        <div class="co-coupon-label"><i class="ri-coupon-3-fill"></i> Coupon Code</div>
                        <div class="co-coupon-row">
                            <input type="text" class="co-coupon-input" id="coupon_code"
                                placeholder="Enter code..." value="{{ $coupon->code ?? '' }}">
                            <button type="button" class="co-coupon-btn" onclick="applyCoupon()">Apply</button>
                        </div>
                        <div id="coupon-message" class="co-coupon-msg"></div>
                    </div>

                    {{-- Price Breakdown --}}
                    <div class="co-price-block">
                        <div class="co-price-row">
                            <span>Package Price</span>
                            @if($package->original_price)
                            <span class="strike">${{ number_format($package->original_price, 2) }}</span>
                            @else
                            <span>${{ number_format($package->price, 2) }}</span>
                            @endif
                        </div>

                        @if($package->discount_percentage)
                        <div class="co-price-row co-disc">
                            <span>Discount ({{ $package->discount_percentage }}% OFF)</span>
                            <span>−${{ number_format($package->original_price - $package->price, 2) }}</span>
                        </div>
                        @endif

                        <div class="co-price-row co-disc" id="coupon-row" style="{{ isset($coupon) ? '' : 'display:none;' }}">
                            <span>Coupon <span id="coupon-name">({{ $coupon->code ?? '' }})</span></span>
                            <span id="coupon-amount">−${{ isset($discountAmount) ? number_format($discountAmount, 2) : '0.00' }}</span>
                        </div>

                        <div class="co-price-row co-total">
                            <span class="co-total-l">Total Due</span>
                            <span class="co-total-r" id="total-amount">${{ isset($finalPrice) ? number_format($finalPrice, 2) : number_format($package->price, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Guarantee --}}
                <div class="co-guarantee">
                    <div class="co-guar-ic"><i class="ri-refund-2-fill"></i></div>
                    <div class="co-guar-txt">
                        <strong>Money-Back Guarantee</strong>
                        <span>Not satisfied? Full refund within 24 hours.</span>
                    </div>
                </div>

                {{-- Support --}}
                <div class="co-support">
                    <div class="co-sup-ic"><i class="ri-headphone-fill"></i></div>
                    <div class="co-sup-txt">
                        <strong>Need Help?</strong>
                        <span>24/7 live support available</span>
                    </div>
                    <a href="{{ route('contact') }}" class="co-sup-btn"><i class="ri-chat-1-line"></i> Chat</a>
                </div>
            </div>

        </div>{{-- /co-grid --}}
    </div>{{-- /co-wrap --}}
</section>

{{-- Payment Help Modal --}}
<div id="paymentHelpModal" class="co-modal">
    <div class="co-modal-box">
        <button class="co-modal-close" onclick="closePaymentModal()"><i class="ri-close-line"></i></button>
        <div class="co-modal-ic"><i class="ri-headphone-fill"></i></div>
        <h3>Having Payment Issues?</h3>
        <p>Our expert support team is online right now and ready to help you complete your order instantly!</p>
        <div class="co-modal-btns">
            <button onclick="openLiveChat()" class="btn-prim">
                <i class="ri-chat-1-fill"></i> Chat with Support
            </button>
            <button onclick="closePaymentModal()" class="btn-ghost">
                No thanks, I'll try again
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── Crypto toggle ── */
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const cryptoSection = document.getElementById('crypto-currency-section');
    const cryptoSelect  = document.getElementById('crypto_currency');

    function toggleCrypto() {
        const sel = document.querySelector('input[name="payment_method"]:checked');
        if (sel && sel.value === 'crypto') {
            cryptoSection.style.display = 'block';
            if (cryptoSelect) cryptoSelect.required = true;
        } else {
            cryptoSection.style.display = 'none';
            if (cryptoSelect) cryptoSelect.required = false;
        }
    }

    paymentRadios.forEach(r => r.addEventListener('change', toggleCrypto));
    toggleCrypto();

    /* ── Referral uppercase ── */
    const refInput = document.getElementById('referral_code');
    if (refInput) refInput.addEventListener('input', function() { this.value = this.value.toUpperCase(); });

    /* ── Payment error modal ── */
    const errAlert = document.querySelector('.co-alert-err');
    if (errAlert) {
        setTimeout(() => {
            document.getElementById('paymentHelpModal').classList.add('is-active');
        }, 1200);
    }

    /* ── Submit button loading state ── */
    const form   = document.getElementById('co-form');
    const subBtn = document.getElementById('co-submit-btn');
    if (form && subBtn) {
        form.addEventListener('submit', function() {
            subBtn.disabled = true;
            subBtn.innerHTML = '<i class="ri-loader-4-line" style="animation:spin 0.8s linear infinite;"></i> Processing…';
        });
    }
});

/* ── Coupon ── */
function applyCoupon() {
    const code       = document.getElementById('coupon_code').value.trim();
    const msgDiv     = document.getElementById('coupon-message');
    const packageId  = {{ $package->id }};

    if (!code) {
        msgDiv.innerHTML = '<span style="color:#fca5a5;">Please enter a coupon code.</span>';
        return;
    }

    const btn = document.querySelector('.co-coupon-btn');
    btn.textContent = 'Checking…';
    btn.disabled = true;

    fetch('{{ route("checkout.apply-coupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ coupon_code: code, package_id: packageId })
    })
    .then(r => r.json())
    .then(data => {
        btn.textContent = 'Apply';
        btn.disabled = false;

        if (data.valid) {
            msgDiv.innerHTML = `<span style="color:#6ee7b7;display:flex;align-items:center;gap:5px;"><i class="ri-checkbox-circle-fill"></i> ${data.message}</span>`;
            document.getElementById('coupon-row').style.display      = 'flex';
            document.getElementById('coupon-name').innerText         = `(${code})`;
            document.getElementById('coupon-amount').innerText       = `−$${data.discount_amount}`;
            document.getElementById('total-amount').innerText        = `$${data.final_price}`;
            const subBtn = document.getElementById('co-submit-btn');
            if (subBtn) subBtn.innerHTML = `<i class="ri-lock-2-fill"></i> Complete Purchase — $${data.final_price}`;
        } else {
            msgDiv.innerHTML = `<span style="color:#fca5a5;display:flex;align-items:center;gap:5px;"><i class="ri-close-circle-fill"></i> ${data.message}</span>`;
            document.getElementById('coupon-row').style.display = 'none';
        }
    })
    .catch(() => {
        btn.textContent = 'Apply';
        btn.disabled = false;
        msgDiv.innerHTML = '<span style="color:#fca5a5;">Something went wrong. Please try again.</span>';
    });
}

/* ── Modal ── */
function openLiveChat() {
    if (window.$crisp) $crisp.push(['do', 'chat:open']);
    closePaymentModal();
}

function closePaymentModal() {
    document.getElementById('paymentHelpModal').classList.remove('is-active');
}

/* ── Spinner keyframe ── */
const style = document.createElement('style');
style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
document.head.appendChild(style);
</script>
@endpush
