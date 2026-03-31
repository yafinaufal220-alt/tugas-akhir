</div><!-- /.main-wrap -->

<style>
.site-footer {
    padding: 20px 40px;
    border-top: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.site-footer-brand {
    font-family: var(--font-head);
    font-size: 13px;
    font-weight: 700;
    color: var(--muted);
    white-space: nowrap;
}
.site-footer-brand span { color: var(--accent-2); }
.site-footer-copy {
    font-size: 12px;
    color: var(--muted);
    white-space: nowrap;
}

@media (max-width: 480px) {
    .site-footer {
        flex-direction: column;
        align-items: center;
        padding: 16px;
        text-align: center;
        gap: 4px;
    }
}
</style>

<footer class="site-footer">
    <span class="site-footer-brand">STOK<span>PRO</span></span>
    <span class="site-footer-copy">&copy; <?= date('Y') ?> — Inventory Management System</span>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('[data-animate]');
    items.forEach((el, i) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(16px)';
        el.style.transition = `opacity 0.4s ease ${i * 0.05}s, transform 0.4s ease ${i * 0.05}s`;
        setTimeout(() => { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; }, 50);
    });

    document.querySelectorAll('.tbl-row').forEach(row => {
        row.addEventListener('mouseenter', () => row.style.background = 'rgba(255,255,255,0.04)');
        row.addEventListener('mouseleave', () => row.style.background = '');
    });
});
</script>
</body>
</html>