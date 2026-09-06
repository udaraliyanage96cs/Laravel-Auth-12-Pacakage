@push('title')
    Activity Logs
@endpush
<x-app-layout>

    <!-- Unified Filter & Table Card -->
    <div class="card custom-card rounded-3 shadow-sm border-0 mb-4 overflow-hidden">
        <!-- Filter Section -->
        <div class="card-body p-3 p-md-4">
            <form method="GET" action="{{ route('activity.logs') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="user_id" class="form-label fw-semibold text-slate-600 mb-1">User</label>
                        <select name="user_id" id="user_id" class="form-select rounded-3">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="action" class="form-label fw-semibold text-slate-600 mb-1">Action</label>
                        <select name="action" id="action" class="form-select rounded-3">
                            <option value="">All Actions</option>
                            @foreach ($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="model_type" class="form-label fw-semibold text-slate-600 mb-1">Model Type</label>
                        <input type="text" name="model_type" id="model_type" class="form-control rounded-3"
                            value="{{ request('model_type') }}" placeholder="Model Type...">
                    </div>

                    <div class="col-md-3">
                        <label for="date_range" class="form-label fw-semibold text-slate-600 mb-1">Date Range</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-slate-400 border-end-0 rounded-start-3">
                                <i class="bx bx-calendar"></i>
                            </span>
                            <input type="text" name="date_range" id="date_range" class="form-control rounded-end-3 daterange-picker border-start-0 ps-0"
                                value="{{ request('date_range') }}" placeholder="Select date range..." readonly>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex align-items-end justify-content-end gap-1">
                        <button type="submit" class="btn btn-icon-square btn-success shadow-sm" title="Apply Filters"
                            data-bs-toggle="tooltip">
                            <i class="bx bx-search fs-6"></i>
                        </button>
                        <a href="{{ route('activity.logs') }}" class="btn btn-icon-square btn-secondary shadow-sm"
                            title="Reset Filters" data-bs-toggle="tooltip">
                            <i class="bx bx-refresh fs-6"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="table-responsive border-top">
            <table class="table custom-table mb-0">
                <thead class="bg-dark">
                    <tr>
                        <th class="ps-3">User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Model Type</th>
                        <th>Model ID</th>
                        <th class="pe-3">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold text-slate-800" style="font-size: 0.88rem;">{{ $log->user->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $actionLower = strtolower($log->action);
                                @endphp
                                @if(in_array($actionLower, ['created', 'stored', 'login', 'approved']))
                                    <span class="status-badge-approved">{{ ucfirst($log->action) }}</span>
                                @elseif(in_array($actionLower, ['updated', 'edited', 'rotated']))
                                    <span class="badge bg-label-info px-2.5 py-1 text-uppercase fw-semibold" style="font-size: 0.7rem; border-radius: 6px;">{{ ucfirst($log->action) }}</span>
                                @elseif(in_array($actionLower, ['deleted', 'destroyed', 'delete']))
                                    <span class="status-badge-deleted">{{ ucfirst($log->action) }}</span>
                                @elseif(in_array($actionLower, ['disapproved', 'disabled', 'logout', 'deactivate']))
                                    <span class="status-badge-pending">{{ ucfirst($log->action) }}</span>
                                @else
                                    <span class="badge bg-label-secondary px-2.5 py-1 text-uppercase fw-semibold" style="font-size: 0.7rem; border-radius: 6px;">{{ ucfirst($log->action) }}</span>
                                @endif
                            </td>
                            <td><span class="text-slate-700 text-wrap" style="max-width: 320px; display: inline-block;">{{ $log->description }}</span></td>
                            <td><span class="badge bg-label-secondary px-2.5 py-1 text-uppercase fw-semibold" style="font-size: 0.7rem; border-radius: 6px;">{{ class_basename($log->model_type) }}</span></td>
                            <td><span class="fw-semibold text-slate-700">{{ $log->model_id == 0 ? 'N/A' : '#' . $log->model_id }}</span></td>
                            <td><span class="text-slate-500 small">{{ $log->created_at->format('M d, Y • h:i A') }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bx bx-info-circle fs-3 d-block mb-1"></i>
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Pagination -->
        <div class="px-3 py-3 border-top d-flex justify-content-between align-items-center flex-wrap bg-white">
            <div class="table-footer-text mb-2 mb-md-0">
                Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} activity logs
            </div>
            <div>
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</x-app-layout>
