@extends('layouts.admin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <!-- Header -->
    <div class="gemini-card" style="margin-bottom: 24px; border-radius: 16px;">
        <div style="display: flex; align-items: center; justify-content: between; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #4285f4, #34a853); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user" style="color: white; font-size: 24px;"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 32px; font-weight: 400; color: var(--gemini-text);">{{ $lead->full_name }}</h1>
                    <p style="margin: 4px 0 0 0; color: var(--gemini-text-secondary); font-size: 16px;">Potensial mijoz ma'lumotlari</p>
                </div>
            </div>
            <div style="display: flex; gap: 12px; margin-left: auto;">
                <a href="{{ route('admin.leads.edit', $lead) }}" class="gemini-btn-secondary">
                    <i class="fas fa-edit"></i>
                    Tahrirlash
                </a>
                <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="gemini-btn" style="background: #ea4335;" onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                        <i class="fas fa-trash"></i>
                        O'chirish
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Main Info -->
        <div class="gemini-card" style="border-radius: 16px;">
            <h2 style="margin: 0 0 24px 0; font-size: 20px; font-weight: 500; color: var(--gemini-text);">Asosiy ma'lumotlar</h2>
            
            <div style="display: grid; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--gemini-bg); border-radius: 12px;">
                    <i class="fas fa-phone" style="color: var(--gemini-blue); font-size: 18px; width: 24px;"></i>
                    <div>
                        <div style="font-size: 14px; color: var(--gemini-text-secondary); margin-bottom: 4px;">Telefon</div>
                        <div style="font-size: 16px; font-weight: 500; color: var(--gemini-text);">{{ $lead->phone }}</div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--gemini-bg); border-radius: 12px;">
                    <i class="fas fa-book" style="color: var(--gemini-blue); font-size: 18px; width: 24px;"></i>
                    <div>
                        <div style="font-size: 14px; color: var(--gemini-text-secondary); margin-bottom: 4px;">Kurs</div>
                        <div style="font-size: 16px; font-weight: 500; color: var(--gemini-text);">{{ $lead->course->name ?? 'Tanlanmagan' }}</div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--gemini-bg); border-radius: 12px;">
                    <i class="fas fa-source" style="color: var(--gemini-blue); font-size: 18px; width: 24px;"></i>
                    <div>
                        <div style="font-size: 14px; color: var(--gemini-text-secondary); margin-bottom: 4px;">Manba</div>
                        <span style="background: var(--gemini-blue); color: white; padding: 6px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                            {{ ucfirst(str_replace('_', ' ', $lead->source)) }}
                        </span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--gemini-bg); border-radius: 12px;">
                    <i class="fas fa-flag" style="color: var(--gemini-blue); font-size: 18px; width: 24px;"></i>
                    <div>
                        <div style="font-size: 14px; color: var(--gemini-text-secondary); margin-bottom: 4px;">Holat</div>
                        <span style="background: #34a853; color: white; padding: 6px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                            {{ ucfirst($lead->status) }}
                        </span>
                    </div>
                </div>

                @if($lead->follow_up_date)
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--gemini-bg); border-radius: 12px;">
                    <i class="fas fa-calendar" style="color: var(--gemini-blue); font-size: 18px; width: 24px;"></i>
                    <div>
                        <div style="font-size: 14px; color: var(--gemini-text-secondary); margin-bottom: 4px;">Kuzatuv sanasi</div>
                        <div style="font-size: 16px; font-weight: 500; color: var(--gemini-text);">{{ $lead->follow_up_date->format('d.m.Y') }}</div>
                    </div>
                </div>
                @endif

                @if($lead->notes)
                <div style="padding: 16px; background: var(--gemini-bg); border-radius: 12px;">
                    <div style="font-size: 14px; color: var(--gemini-text-secondary); margin-bottom: 8px;">Izohlar</div>
                    <div style="font-size: 16px; color: var(--gemini-text); line-height: 1.5;">{{ $lead->notes }}</div>
                </div>
                @endif

                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--gemini-bg); border-radius: 12px;">
                    <i class="fas fa-clock" style="color: var(--gemini-blue); font-size: 18px; width: 24px;"></i>
                    <div>
                        <div style="font-size: 14px; color: var(--gemini-text-secondary); margin-bottom: 4px;">Qo'shilgan sana</div>
                        <div style="font-size: 16px; font-weight: 500; color: var(--gemini-text);">{{ $lead->created_at->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activities -->
        <div>
            <!-- Add Activity -->
            <div class="gemini-card" style="margin-bottom: 24px; border-radius: 16px;">
                <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 500; color: var(--gemini-text);">Yangi faoliyat</h3>
                <form method="POST" action="{{ route('admin.leads.add-activity', $lead) }}">
                    @csrf
                    <div style="margin-bottom: 16px;">
                        <label class="gemini-label">Tur</label>
                        <select name="type" class="gemini-select" required>
                            <option value="call">Qo'ng'iroq</option>
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                            <option value="meeting">Uchrashuv</option>
                            <option value="note">Eslatma</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label class="gemini-label">Mavzu</label>
                        <input type="text" name="subject" class="gemini-input" placeholder="Mavzu kiriting">
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label class="gemini-label">Tavsif</label>
                        <textarea name="description" class="gemini-textarea" rows="3" required placeholder="Tavsif kiriting"></textarea>
                    </div>
                    <button type="submit" class="gemini-btn" style="width: 100%;">
                        <i class="fas fa-plus"></i>
                        Qo'shish
                    </button>
                </form>
            </div>

            <!-- Activities History -->
            <div class="gemini-card" style="border-radius: 16px;">
                <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 500; color: var(--gemini-text);">Faoliyatlar tarixi</h3>
                <div style="max-height: 400px; overflow-y: auto;">
                    @forelse($lead->activities()->latest()->get() as $activity)
                    <div style="padding: 16px; border: 1px solid var(--gemini-border); border-radius: 12px; margin-bottom: 12px; background: var(--gemini-bg);">
                        <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 8px;">
                            <span style="background: var(--gemini-blue); color: white; padding: 4px 12px; border-radius: 16px; font-size: 12px; font-weight: 500;">
                                {{ ucfirst($activity->type) }}
                            </span>
                            <small style="color: var(--gemini-text-secondary);">{{ $activity->created_at->format('d.m.Y H:i') }}</small>
                        </div>
                        @if($activity->subject)
                            <div style="font-weight: 500; margin-bottom: 4px; color: var(--gemini-text);">{{ $activity->subject }}</div>
                        @endif
                        <div style="color: var(--gemini-text-secondary); font-size: 14px;">{{ $activity->description }}</div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">
                        <i class="fas fa-history" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                        <p>Faoliyatlar yo'q</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection