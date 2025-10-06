@extends('layouts.app')

@section('title', 'Groups List')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-users"></i> Groups Management</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/index') }}">Home</a></li>
            <li class="breadcrumb-item active">Groups</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title mb-0 flex-grow-1">List of All Groups</h3>
          <a href="{{ route('groups.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Group
          </a>
        </div>
        <div class="card-body">
          <table id="groupsTable" class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th>Group Name</th>
                <th>Leader</th>
                <th>Members</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($groups as $group)
              <tr>
                <td>{{ $group->name }}</td>
                <td>{{ $group->leader->name ?? '—' }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" 
                            data-toggle="modal" 
                            data-target="#membersModal{{ $group->id }}">
                        <i class="fas fa-eye"></i> View ({{ $group->members->count() }})
                    </button>
                </td>
                <td>
                  <div class="btn-group">
                    {{-- {{ route('groups.edit', $group->id) }} --}}
<button 
    type="button" 
    class="btn btn-warning btn-sm btn-edit-group"
    data-id="{{ $group->id }}"
    data-name="{{ $group->name }}"
    data-leader="{{ $group->leader_id }}"
    data-members='@json($group->members->pluck("id"))'>
  <i class="fas fa-edit"></i>
</button>

                    {{-- {{ route('groups.destroy', $group->id) }} --}}
                    <form action="" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm btn-delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-4">
                  <i class="fas fa-users-slash fa-3x mb-3"></i>
                  <br>
                  No groups found
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Edit Group Modal -->
<div class="modal fade" id="editGroupModal" tabindex="-1" aria-labelledby="editGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editGroupForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editGroupModalLabel"><i class="fas fa-edit"></i> Edit Group</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="editGroupId">

          <div class="form-group">
            <label for="editGroupName">Group Name</label>
            <input type="text" class="form-control" id="editGroupName" name="group_name" required>
          </div>

          <div class="form-group">
            <label for="editGroupLeader">Leader</label>
            <select class="form-control select2" id="editGroupLeader" name="leader" style="width: 100%;">
              <option value="">Select Leader</option>
              @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="editGroupMembers">Members</label>
            <select class="form-control select2" id="editGroupMembers" name="members[]" multiple style="width: 100%;">
              @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($groups as $group)
<div class="modal fade" id="membersModal{{ $group->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">Members in: {{ $group->name }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($group->members->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    {{-- <th width="50">#</th> --}}
                                    <th>Member Name</th>
                                    <th>Course</th>
                                    <th width="100">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $leader = $group->leader;
                                    $otherMembers = $group->members->where('id', '!=', $leader->id ?? null);
                                @endphp
                                
                                @if($leader)
                                <tr class="table-success leader-row">
                                    {{-- <td><span class="badge badge-success">1</span></td> --}}
                                    <td>
                                        <strong>{{ $leader->name }}</strong>
                                        <i class="fas fa-crown text-warning ml-1" title="Group Leader"></i>
                                    </td>
                                    <td>{{ $leader->course ?? 'Not specified' }}</td>
                                    <td>
                                        <span class="badge badge-warning">Leader</span>
                                    </td>
                                </tr>
                                @endif
                                
                                @foreach($otherMembers as $index => $member)
                                <tr>
                                    {{-- <td><span class="badge badge-primary">{{ $index + 2 }}</span></td> --}}
                                    <td><strong>{{ $member->name }}</strong></td>
                                    <td>{{ $member->course ?? 'Not specified' }}</td>
                                    <td>
                                        <span class="badge badge-secondary">Member</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 text-center">
                        <div class="badge badge-success p-2">
                            Total Members: {{ $group->members->count() }}
                        </div>
                        @if($leader)
                        <div class="badge badge-warning p-2 ml-2">
                            <i class="fas fa-crown"></i> 1 Leader
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Members</h5>
                        <p class="text-muted">This group doesn't have any members yet.</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#groupsTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true
    });

    // Delete confirmation
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the group.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
$(document).ready(function() {
    $('.btn-edit-group').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const leader = $(this).data('leader');
        const members = $(this).data('members');

        // Populate modal fields
        $('#editGroupId').val(id);
        $('#editGroupName').val(name);
        $('#editGroupLeader').val(leader).trigger('change');
        $('#editGroupMembers').val(members).trigger('change');

        // Set the form action dynamically
        $('#editGroupForm').attr('action', `/groups/${id}`);

        // Show modal
        $('#editGroupModal').modal('show');
    });
});
</script>

<style>
.table-responsive {
    max-height: 400px;
    overflow-y: auto;
}

.leader-row {
    background-color: #d4edda !important;
    border-left: 4px solid #28a745;
}

.leader-row:hover {
    background-color: #c3e6cb !important;
}

.fa-crown {
    color: #ffc107;
}
</style>
@endsection