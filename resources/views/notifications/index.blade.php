<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<style>
    .select2-container--classic .select2-selection--multiple {
        height: 40px !important;
    }

    .table td.word-wrap {
        word-wrap: break-word;
        white-space: pre-wrap;
        max-width: 250px;
    }
</style>
@push('title') Notifications @endpush
<x-app-layout>

    @can('view_notification_management')
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Notifications</h5>
            </div>

            @can(['manual_notification_management'])
                <div class="card-body">
                    <h6 class="mb-4">Send System Notifications Manually</h6>
                    <form action="{{ route('notifications.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="users" class="mb-2">Select Users</label>
                                <div class="select2-primary" id="mySelect">
                                    <select id="select2Primary" class="select2 form-select" name="users[]" multiple required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3">
                                <label for="title">Notification Title</label>
                                <input type="text" class="form-control" name="title" id="title" required />
                                <label for="message" class="mt-2">Notification Message</label>
                                <textarea class="form-control" name="message" id="message" rows="4" required></textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <button type="reset" class="btn btn-label-secondary  me-2">Discard</button>
                            <button type="submit" class="btn btn-success">Send Notification</button>
                        </div>
                    </form>
                </div>
            @endcan
            
            <div class="table-responsive text-wrap">
                <table class="table table-striped table-borderless">
                    <thead class="bg-dark">
                        <tr>
                            <th class="text-nowrap">Title</th>
                            <th class="text-nowrap">Message</th>
                            <th class="text-nowrap">Sender</th>
                            <th class="text-nowrap">Date</th>
                            <th class="text-nowrap text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($notifications->isEmpty())
                            <tr>
                                <td colspan="5" >No notifications found</td>
                            </tr>
                        @else
                            @foreach ($notifications as $notification)
                                <tr>
                                    <td class="text-nowrap">{{ $notification->data['title'] }}</td>
                                    <td class="word-wrap">{{ $notification->data['message'] }}</td>
                                    <td class="text-nowrap">
                                        {{ isset($notification->data['sender']) ? $notification->data['sender']['name'] : 'N/A' }}
                                    </td>
                                    <td class="text-nowrap">{{ $notification->created_at->diffForHumans() }}</td>
                                    <td class="text-end text-nowrap">
                                        @if (!$notification->read_at)
                                            <form action="/notifications/read/{{ $notification->id }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-icon btn-success mr-1 mb-1"> <i
                                                        class='bx bxs-envelope-open'></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            
            
        </div>
    @endcan

    <script>
        if ($.fn.select2) {
            $('#select2Primary').select2({
                theme: 'classic' 
            });
        } else {
            console.error("Select2 is not loaded");
        }
    </script>
</x-app-layout>
