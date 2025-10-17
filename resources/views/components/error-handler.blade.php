@if($errors->any())
<div style="background: rgba(244, 67, 54, 0.1); border: 1px solid #f44336; border-left: 4px solid #f44336; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
        <i class="fas fa-exclamation-triangle" style="color: #f44336;"></i>
        <strong style="color: #f44336;">Xatoliklar mavjud:</strong>
    </div>
    <ul style="margin: 0; padding-left: 20px; color: #f44336;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
<div style="background: rgba(76, 175, 80, 0.1); border: 1px solid #4caf50; border-left: 4px solid #4caf50; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-check-circle" style="color: #4caf50;"></i>
        <span style="color: #4caf50;">{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div style="background: rgba(244, 67, 54, 0.1); border: 1px solid #f44336; border-left: 4px solid #f44336; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-exclamation-circle" style="color: #f44336;"></i>
        <span style="color: #f44336;">{{ session('error') }}</span>
    </div>
</div>
@endif

@if(session('warning'))
<div style="background: rgba(255, 152, 0, 0.1); border: 1px solid #ff9800; border-left: 4px solid #ff9800; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-exclamation-triangle" style="color: #ff9800;"></i>
        <span style="color: #ff9800;">{{ session('warning') }}</span>
    </div>
</div>
@endif