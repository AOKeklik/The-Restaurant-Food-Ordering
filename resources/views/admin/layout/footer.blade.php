 <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset("dist/modules/jquery.min.js") }}"></script>
  <script src="{{ asset("dist/modules/popper.js") }}"></script>
  <script src="{{ asset("dist/modules/tooltip.js") }}"></script>
  <script src="{{ asset("dist/modules/bootstrap/js/bootstrap.min.js") }}"></script>
  <script src="{{ asset("dist/modules/nicescroll/jquery.nicescroll.min.js") }}"></script>
  <script src="{{ asset("dist/modules/moment.min.js") }}"></script>
  <script src="{{ asset("dist/js/stisla.js") }}"></script>
  
  <!-- JS Libraies -->
  <script src="{{ asset("dist/modules/jquery.sparkline.min.js") }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset("dist/js/page/modules-sparkline.js") }}"></script>
  
  <!-- Template JS File -->
  <script src="{{ asset("dist/js/scripts.js") }}"></script>
  <script src="{{ asset("dist/js/custom.js") }}"></script>
  @yield("scripts")
</body>
</html>