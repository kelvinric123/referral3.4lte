<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history mr-2"></i>
            Referral Timeline
        </h3>
    </div>
    <div class="card-body">
        <div class="timeline">
            @if($referral->statusHistories->count() > 0)
                @foreach($referral->statusHistories as $index => $history)
                    <div class="time-label">
                        <span class="bg-{{ $history->status_color }}">
                            {{ $history->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                    <div>
                        <i class="{{ $history->status_icon }} bg-{{ $history->status_color }}"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i> {{ $history->created_at->format('h:i A') }}
                            </span>
                            <h3 class="timeline-header">
                                @if($history->status === 'Created')
                                    <strong>Referral Created</strong>
                                @elseif($history->previous_status)
                                    <strong>Status changed from {{ $history->previous_status }} to {{ $history->status }}</strong>
                                @else
                                    <strong>Status set to {{ $history->status }}</strong>
                                @endif
                            </h3>
                            <div class="timeline-body">
                                <p class="mb-1">
                                    <strong>By:</strong> {{ $history->changed_by_name }}
                                    @if($history->changed_by_type)
                                        <span class="badge badge-secondary ml-1">{{ $history->changed_by_type }}</span>
                                    @endif
                                </p>
                                @if($history->notes)
                                    <div class="mt-2">
                                        <strong>Notes:</strong>
                                        <div class="border-left pl-3 ml-2 text-muted">
                                            {{ $history->notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <p>No status history available.</p>
                </div>
            @endif
            <div>
                <i class="fas fa-clock bg-secondary"></i>
            </div>
        </div>
    </div>
    @if(in_array($referral->status, ['Pending', 'Approved']))
        <div class="card-footer">
            <h6 class="text-muted mb-2">Update Status:</h6>
            <form action="{{ route('admin.referrals.update-status', $referral->id) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="form-group mb-2">
                    <label for="status" class="sr-only">New Status</label>
                    <select class="form-control form-control-sm" name="status" required>
                        @if($referral->status == 'Pending')
                            <option value="">Select Status</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        @elseif($referral->status == 'Approved')
                            <option value="">Select Status</option>
                            <option value="Completed">Completed</option>
                            <option value="No Show">No Show</option>
                        @endif
                    </select>
                </div>
                
                <div class="form-group mb-2">
                    <label for="notes" class="sr-only">Notes</label>
                    <textarea class="form-control form-control-sm" name="notes" rows="2" placeholder="Add notes about this status change..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save mr-1"></i> Update Status
                </button>
            </form>
        </div>
    @endif
</div>

<style>
.timeline {
    position: relative;
    margin: 0 0 30px 0;
    padding: 0;
    list-style: none;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #ddd;
    left: 31px;
    margin: 0;
    border-radius: 2px;
}

.timeline > div {
    position: relative;
    margin: 0 0 15px 0;
}

.timeline > div > .timeline-item {
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    border-radius: 3px;
    margin-top: 0;
    background: #fff;
    color: #444;
    margin-left: 60px;
    margin-right: 15px;
    padding: 0;
    position: relative;
}

.timeline > div > .timeline-item > .time {
    color: #999;
    float: right;
    padding: 10px;
    font-size: 12px;
}

.timeline > div > .timeline-item > .timeline-header {
    margin: 0;
    color: #555;
    border-bottom: 1px solid #f4f4f4;
    padding: 10px;
    font-size: 16px;
    line-height: 1.1;
}

.timeline > div > .timeline-item > .timeline-body,
.timeline > div > .timeline-item > .timeline-footer {
    padding: 10px;
}

.timeline > div > .fa,
.timeline > div > .fas,
.timeline > div > .far,
.timeline > div > .fab,
.timeline > div > .fal,
.timeline > div > .fad,
.timeline > div > .svg-inline--fa {
    position: absolute;
    left: 18px;
    background: #aaa;
    color: #666;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    text-align: center;
    line-height: 30px;
    font-size: 15px;
}

.timeline > .time-label > span {
    font-weight: 600;
    color: #fff;
    border-radius: 4px;
    display: inline-block;
    padding: 5px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    top: 13px;
    left: -15px;
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent;
    border-right: 7px solid #fff;
}

.bg-primary {
    background-color: #007bff !important;
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-danger {
    background-color: #dc3545 !important;
}

.bg-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.bg-secondary {
    background-color: #6c757d !important;
}
</style> 