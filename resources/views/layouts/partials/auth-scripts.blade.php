@php
    $translationsJs = 'js/translations.js';
    $translationsVer = file_exists(public_path($translationsJs)) ? filemtime(public_path($translationsJs)) : time();
@endphp
<script src="{{ asset($translationsJs) }}?v={{ $translationsVer }}" defer></script>
<script>
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    const ic  = btn.querySelector('i');
    if (inp.type === 'password') { inp.type = 'text'; ic.className = 'ri-eye-line'; }
    else { inp.type = 'password'; ic.className = 'ri-eye-off-line'; }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-lang-switcher]').forEach(function (switcher) {
        const toggle = switcher.querySelector('[data-lang-toggle]');
        const menu = switcher.querySelector('[data-lang-menu]');
        if (!toggle || !menu) return;

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = switcher.classList.contains('is-open');
            document.querySelectorAll('[data-lang-switcher].is-open').forEach(function (open) {
                open.classList.remove('is-open');
                const t = open.querySelector('[data-lang-toggle]');
                if (t) t.setAttribute('aria-expanded', 'false');
            });
            if (!isOpen) {
                switcher.classList.add('is-open');
                toggle.setAttribute('aria-expanded', 'true');
            }
        });
    });

    document.addEventListener('click', function () {
        document.querySelectorAll('[data-lang-switcher].is-open').forEach(function (switcher) {
            switcher.classList.remove('is-open');
            const toggle = switcher.querySelector('[data-lang-toggle]');
            if (toggle) toggle.setAttribute('aria-expanded', 'false');
        });
    });
});
</script>
</body>
</html>
