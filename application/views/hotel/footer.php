   <footer class="footer bg-light py-3 mt-auto text-center">
                        <div class="container">
                            <span class="text-muted">&copy; <?= date('Y') ?> <?= isset($_SESSION['hotel_name']) ? $_SESSION['hotel_name'] : 'Hotel' ?>. All Rights Reserved.</span>
                        </div>
                    </footer>
              
  </div>
            </main>
        </div>
    </div>
    <script src="<?=base_url("/assets/")?>js/app.js"></script>
</body>
</html>
