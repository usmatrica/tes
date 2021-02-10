<div class="container">
  <div class="row">
    <div class="col-md-6">
      @if (session()->has('success'))
        <div class="alert alert-success">
          {{ session()->get('success') }}
        </div>   
      @endif
    </div>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-6">
      @if (session()->has('error'))
        <div class="alert alert-danger">
          {{ session()->get('error') }}
        </div>   
      @endif
    </div>
  </div>
</div>