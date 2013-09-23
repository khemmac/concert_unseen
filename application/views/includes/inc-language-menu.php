<ul id="menu-language">
	<li><a class="menu-th <?= language_helper_is_th($this)?'active':'' ?>" href="<?= site_url('language/th') ?>">TH</a></li>
	<li class="menu-sep">|</li>
	<li><a class="menu-en <?= language_helper_is_en($this)?'active':'' ?>" href="<?= site_url('language/en') ?>">EN</a></li>
</ul>