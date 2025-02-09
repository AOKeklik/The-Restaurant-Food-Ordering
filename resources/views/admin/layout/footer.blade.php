            <footer class="main-footer">
                <div class="footer-left">
                Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="">Abdullah Onur</a>
                </div>
                <div class="footer-right">
                
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset("dist/back/js/jquery.min.js") }}"></script>
    <script src="{{ asset("dist/back/js/popper.js") }}"></script>
    <script src="{{ asset("dist/back/js/tooltip.js") }}"></script>
    <script src="{{ asset("dist/back/js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("dist/back/js/jquery.nicescroll.min.js") }}"></script>
    <script src="{{ asset("dist/back/js/iziToast.min.js") }}"></script>
    <script src="{{ asset("dist/back/js/stisla.js") }}"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.1.1/js/bootstrap5-toggle.jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template JS File -->
    <script src="{{ asset("dist/back/js/scripts.js") }}"></script>
    <script src="{{ asset("dist/back/js/custom.js") }}"></script>

    <!-- Session Messages -->
    @if(Session::has("error"))
    <script>
            iziToast.show({
            title: "{{ Session::get("error") }}",
            position: "topRight",
            color: "red"
        })
    </script>
    @endif
    @if(Session::has("success"))
    <script>
            iziToast.show({
            title: "{{ Session::get("success") }}",
            position: "topRight",
            color: "green"
        })
    </script>
    @endif

    <!-- Datatable -->
    <script>
        $(document).ready(function () {
            const table = $('#example').DataTable({
                order: [], 
                paging: true, 
                searching: true,
                "paging": true,
            })

            if(table.data().count() === 0) {
                table.destroy()
                $('#example').DataTable({
                    order: [], 
                    paging: true, 
                    searching: true,
                    "paging": false,
                })
            }
        })
    </script>

    
    @stack("scripts")
</body>
</html>