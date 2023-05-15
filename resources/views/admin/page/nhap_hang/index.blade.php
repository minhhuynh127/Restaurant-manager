@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">

    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            new Vue({
                el: '#app',
                data: {

                },
                created() {

                },
                methods: {

                },
            });
        })
    </script>
@endsection
