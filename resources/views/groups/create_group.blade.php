@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create New Group</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/index') }}">Home</a></li>
            <li class="breadcrumb-item active">Create Group</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Group Details</h3>
            </div>

            <!-- form start -->
            <form action="{{ route('groups.store') }}" method="POST" id="groupForm">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="group_name">Group Name</label>
                      <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter group name">
                    </div>
                  </div>
                  {{-- <div class="col-md-6">
                    <div class="form-group">
                      <label for="members">Select Members</label>
                      <select class="form-control select2" id="members" name="members[]" multiple="multiple" style="width: 100%;">
                        @foreach($members as $member)
                          <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div> --}}
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                        <label>Group Members</label>
                        <div class="select2-purple">
                            <select class="select2" multiple="multiple" data-placeholder="Members" data-dropdown-css-class="select2-blue" name="members[]" style="width: 100%;">
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="leader">Select Group Leader</label>
                      <select class="form-control" id="leader" name="leader" style="width: 100%;">
                        <option selected disabled>Choose leader</option>
                        @foreach($members as $member)
                          <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Group</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
</div>
@endsection

@push('scripts')

{{-- <script>
  // Initialize Select2 (if used)
  $(function() {
    $('.select2').select2({
      placeholder: "Select members",
      allowClear: true
    });
  });

  // AJAX submission for group creation
  $('#groupForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
      url: "{{ route('groups.store') }}",
      method: "POST",
      data: $(this).serialize(),
      success: function(response) {
        if (response.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message,
            timer: 2000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "{{ route('groups.index') }}";
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message
          });
        }
      },
      error: function(xhr) {
        let res = xhr.responseJSON;
        if (res && res.errors) {
          let messages = Object.values(res.errors).flat().join('\n');
          Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: messages
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: res?.message || 'Something went wrong.'
          });
        }
      }
    });
  });
</script> --}}
@endpush
