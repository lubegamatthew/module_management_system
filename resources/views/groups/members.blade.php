@extends('layouts.app')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>All Students</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/index') }}">Home</a></li>
              <li class="breadcrumb-item active">All Students</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0 flex-grow-1">List Of All Students</h3>
                    <a href="{{ route('members.add') }}" class="btn btn-primary btn-sm ms-auto">
                        <i class="fas fa-user-plus"></i> Add Student
                    </a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Course</th>
                        <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->course }}</td>
                            <td>
                            @if ($user->login_status === '1')
                                <span class="badge bg-info text-dark">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No student data here</td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
</script>

@endsection
