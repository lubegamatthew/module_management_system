@extends('layouts.app')

@section('content')
<style>
    /* ===== Group Card Styles ===== */
    .group-card {
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        overflow: hidden;
        border: none;
        background: #fff;
    }

    .group-header {
        /* background: linear-gradient(135deg, #6a82fb, #fc5c7d); */
        color: black !important;
        padding: 15px 20px;
        position: relative;
    }

    .group-header .username a {
        color: rgb(36, 67, 205);
        font-weight: 600;
        font-size: 1.2rem;
    }

    .group-header .description {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
    }

    .group-body {
        padding: 20px;
    }

    /* ===== Members Section ===== */
    .members-section {
        margin: 15px 0;
    }

    .members-section h6 {
        font-weight: 600;
        margin-bottom: 15px;
        color: #495057;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 8px;
    }

    .member-card {
        text-align: center;
        padding: 12px 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .member-card:hover {
        background-color: #f8f9fa;
        border-color: #eaeaea;
        transform: translateY(-3px);
    }

    .member-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 10px;
        border: 3px solid #eaeaea;
    }

    .member-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: #343a40;
    }

    .member-role,
    .leader-badge,
    .creator-badge {
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 12px;
        padding: 3px 10px;
        display: inline-block;
        margin-top: 5px;
    }

    .member-role {
        background: #f1f3f4;
        color: #6c757d;
    }

    .leader-badge {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
    }

    .creator-badge {
        background: linear-gradient(45deg, #17a2b8, #6f42c1);
        color: white;
    }

    /* ===== Meta Info ===== */
    .group-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
        font-size: 0.9rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .meta-item i {
        opacity: 0.8;
    }

    /* ===== Actions ===== */
    .action-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-top: 1px solid #eaeaea;
        flex-wrap: wrap;
        gap: 10px;
    }

    .action-buttons a {
        font-weight: 500;
        margin-right: 15px;
    }

    .comment-input {
        border-radius: 25px;
        padding: 10px 15px;
    }

    /* ===== Empty State ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        color: #dee2e6;
    }

    .empty-state p {
        font-size: 1.1rem;
    }

    /* ===== Responsive Fixes ===== */
    @media (max-width: 768px) {
        .group-header .username a {
            font-size: 1rem;
        }
        .member-img {
            width: 60px;
            height: 60px;
        }
        .action-stats {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="content-wrapper">
    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1><i class="fas fa-users mr-2"></i>My Group</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/index') }}">Home</a></li>
                        <li class="breadcrumb-item active">My Group</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Page Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#activity" data-toggle="tab">
                                <i class="fas fa-users mr-1"></i> My Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#timeline" data-toggle="tab">
                                <i class="fas fa-comments mr-1"></i> Chat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#settings" data-toggle="tab">
                                <i class="fas fa-cog mr-1"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <!-- ===== My Team Tab ===== -->
                        <div class="active tab-pane" id="activity">
                            @foreach ($groups as $group)
                            <div class="post group-card">
                                <div class="group-header">
                                    <div class="user-block d-flex align-items-center">
                                        {{-- <img class="img-circle img-bordered-sm mr-2"
                                            src="{{ $group->leader->profile_photo_url ?? asset('dist/img/user1-128x128.jpg') }}"
                                            alt="Leader Image"> --}}
                                        <div>
                                            <span class="username" style="text-align: center !important; align-items: center !important;">
                                                <a href="#">{{ $group->name }}</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="group-body">
                                    <div class="members-section">
                                        <h6><i class="fas fa-user-friends mr-2"></i>Group Members</h6>
                                        <div class="row">
                                            @forelse ($group->members as $member)
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                                                <div class="member-card">
                                                    <i class="nav-icon fas fa-user" style=""></i>
                                                    <div class="member-name">{{ $member->name }}</div>
                                                    @if($member->id == $group->leader_id)
                                                        <span class="leader-badge">Leader</span>
                                                    @elseif($member->id == $group->created_by)
                                                        <span class="creator-badge">Creator</span>
                                                    @else
                                                        <span class="member-role">Member</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @empty
                                            <div class="col-12 text-center py-4">
                                                <i class="fas fa-user-friends text-muted mb-2" style="font-size: 2rem;"></i>
                                                <p class="text-muted">No members found in this group.</p>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="action-stats">
                                        <div class="meta-item"><i class="fas fa-crown"></i> Leader: <span style="font-weight: bolder; color:chocolate">{{ $group->leader->name ?? 'N/A' }}</span></div>
                                        <div class="meta-item"><i class="fas fa-user-plus"></i> Created by: {{ $group->creator->name ?? 'N/A' }}</div>
                                        <div class="meta-item"><i class="far fa-clock"></i> {{ $group->created_at->diffForHumans() }}</div>
                                        <div class="meta-item"><i class="fas fa-users"></i> {{ $group->members->count() }} Members</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @if ($groups->isEmpty())
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h4 class="mt-3 text-muted">No Groups Available</h4>
                                <p class="text-muted">You haven't joined any groups yet.</p>
                                <button class="btn btn-primary mt-3">
                                    <i class="fas fa-plus mr-2"></i>Create a Group
                                </button>
                            </div>
                            @endif
                        </div>

                        <!-- ===== Chat & Settings (Unchanged) ===== -->
                        <div class="tab-pane" id="timeline"></div>
                        <div class="tab-pane" id="settings"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
