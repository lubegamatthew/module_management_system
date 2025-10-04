@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>All Uploaded Notes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ '/index' }}">Home</a></li>
              <li class="breadcrumb-item active">Notes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Our Notes</h5>
                <input type="file" id="uploadNotesInput" style="display: none;" accept=".pdf,.doc,.docx,.ppt,.pptx">
                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('uploadNotesInput').click();">
                    <i class="fas fa-upload"></i> Upload Notes
                </button>
            </div>

            <script>
                document.getElementById('uploadNotesInput').addEventListener('change', async function(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const { value: noteName } = await Swal.fire({
                        title: 'Enter Notes Name',
                        input: 'text',
                        inputLabel: `File selected: ${file.name}`,
                        inputPlaceholder: 'Enter the note title',
                        showCancelButton: true,
                        confirmButtonText: 'Upload',
                        cancelButtonText: 'Cancel',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Please enter a name for your note!';
                            }
                        }
                    });

                    if (noteName) {
                        const formData = new FormData();
                        formData.append('note_name', noteName);
                        formData.append('file', file);

                        try {
                            const response = await fetch("{{ route('notes.store') }}", {
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: formData
                            });

                            if (response.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Uploaded!',
                                    text: 'Your note has been uploaded successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                event.target.value = '';
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Upload Failed',
                                    text: 'Something went wrong while uploading. Try again.'
                                });
                            }
                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to connect to the server.'
                            });
                        }
                    } else {
                        event.target.value = '';
                    }
                });
            </script>

                <div class="row">
                    @forelse ($notes as $note)
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box shadow-sm" style="border-radius: 10px;">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-file-alt"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-truncate" title="{{ $note->name }}">
                                        {{ $note->name }}
                                    </span>
                                    <span class="info-box-number text-sm text-muted">
                                        {{ $note->created_at->format('M d, Y') }}
                                    </span>

                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $note->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('notes.download', $note->id) }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No notes uploaded yet.</p>
                        </div>
                    @endforelse
                </div>
        </div>
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
@endsection
