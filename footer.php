    </div>
  </main>
  <footer id="main-footer">
    <div class="page-width">
      <nav>
        <ul>
          <li>
            <a href="<?php echo site_url("/seite1"); ?>">Seite 1</a>
          </li>
          <li>
            <a href="<?php echo get_category_link(get_category_by_slug('cat1')); ?>">Category 1</a>
          </li>
        </ul>
      </nav>
      <?php do_action('skke_footer_hook'); ?>
    </div>
  </footer>
</body>
</html>
