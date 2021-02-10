<!-- Menggunakan file app.blade.php di folder layouts -->
@extends('layouts.app')

<!-- deklarasi html yang akan nanti dieksekusi di yield -->
@section('title','About')

<!-- deklarasi html yang akan nanti dieksekusi di yield -->
@section('head')
<style>
body {
  background: orange;
}
</style>
@endsection

<!-- deklarasi html yang akan nanti dieksekusi di yield -->
@section('content')
<div class="container">
  About
</div>
@endsection