    </main>

    <!-- ========== FOOTER ELEGANT ========== -->
    <style>
        .site-footer {
    position: relative;
    background: linear-gradient(
        135deg,
        #1f2f46 0%,
        #2c3e50 50%,
        #4b6584 100%
    );
    padding: 26px 0;
    color: #ecf0f1;
    text-align: center;
    overflow: hidden;
}

/* garis atas elegan */
.site-footer::before {
    content: "";
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 140px;
    height: 3px;
    background: rgba(255,255,255,0.45);
    border-radius: 4px;
}

/* container */
.site-footer .container {
    position: relative;
    z-index: 1;
}

/* teks copyright */
.site-footer small {
    font-size: 14px;
    letter-spacing: 0.6px;
    opacity: 0.95;
    transition: opacity .3s ease;
}

.site-footer small:hover {
    opacity: 1;
}

/* subtle glow background */
.site-footer::after {
    content: "";
    position: absolute;
    bottom: -120px;
    right: -120px;
    width: 260px;
    height: 260px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
}


@media (max-width: 768px) {
    .site-footer {
        padding: 22px 0;
    }

    .site-footer small {
        font-size: 13px;
        line-height: 1.6;
    }
}

    </style>

  <footer class="site-footer">
    <div class="container">
        <small>
            &copy; <?= date('Y') ?> Generasi Abdi Surabaya for Desa Penanggungan Trawas
        </small>
    </div>
</footer>


</body>
</html>
