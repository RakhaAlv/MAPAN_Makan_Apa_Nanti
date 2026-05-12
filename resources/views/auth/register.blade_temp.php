        <!-- {{-- STEP 1: Pilih role --}}
        <div id="role-selection-container" class="{{ old('role') ? 'hidden' : '' }}">
            <p class="text-sm font-semibold text-gray-600 mb-3 text-center">Pilih jenis akun:</p>
            <div class="grid grid-cols-2 gap-4 mb-8">
                <label class="role-label">
                    <input type="radio" name="role_select" value="user" class="role-input" id="role-user"
                           {{ old('role') === 'user' ? 'checked' : '' }} onchange="switchRole('user')">
                    <div class="role-card">
                        <div class="role-check"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
                        <div class="text-3xl mb-2">🙋</div>
                        <div class="font-semibold text-sm text-gray-700" style="font-family:'Poppins',sans-serif">User</div>
                        <div class="text-xs text-gray-400 mt-1">Cari &amp; review restoran</div>
                    </div>
                </label>
                <label class="role-label">
                    <input type="radio" name="role_select" value="merchant" class="role-input" id="role-merchant"
                           {{ request('role') === 'merchant' || old('role') === 'merchant' ? 'checked' : '' }} onchange="switchRole('merchant')">
                    <div class="role-card">
                        <div class="role-check"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
                        <div class="text-3xl mb-2">🏪</div>
                        <div class="font-semibold text-sm text-gray-700" style="font-family:'Poppins',sans-serif">Merchant</div>
                        <div class="text-xs text-gray-400 mt-1">Daftarkan restoranmu</div>
                    </div>
                </label>
            </div>
        </div> -->
