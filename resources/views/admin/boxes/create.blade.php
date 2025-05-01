@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('boxes.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Qutu Yarat</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Qutu nömrəsi *</label>
                            <input type="text" name="number" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Qeyd</label>
                            <textarea name="note" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Paketin barkodu (Scanner ilə oxut):</label>
                            <input type="text" id="barcodeInput" class="form-control" autofocus>
                            <small id="barcodeStatus" class="text-muted"></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Skan edilmiş barkodlar:</label>
                            <ul id="barcodeList" class="list-group mb-3"></ul>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Təxmini çəkilər:</label>
                            <div id="totalWeight">0 q</div>
                        </div>

                        <!-- Gizli inputlar -->
                        <div id="hiddenInputs"></div>

                        <div class="mb-3 text-end">
                            <button class="btn btn-primary">Yadda saxla</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.includes.footer')

<script>
    const barcodeInput = document.getElementById('barcodeInput');
    const barcodeList = document.getElementById('barcodeList');
    const hiddenInputs = document.getElementById('hiddenInputs');
    const barcodeStatus = document.getElementById('barcodeStatus');
    const totalWeightDiv = document.getElementById('totalWeight');

    let scannedBarcodes = [];
    let totalWeight = 0;

    barcodeInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = barcodeInput.value.trim();

            if (!value || scannedBarcodes.includes(value)) {
                barcodeInput.value = '';
                return;
            }

            // AJAX ilə yoxla: barkod mövcuddur?
            fetch(`/admin/check-barcode?barcode=${value}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        if (data.already_boxed) {
                            barcodeStatus.innerText = '⚠️ Bu paket artıq bir qutuya əlavə olunub!';
                            barcodeStatus.className = 'text-warning';
                        } else {
                            scannedBarcodes.push(value);

                            const li = document.createElement('li');
                            li.className = 'list-group-item d-flex justify-content-between align-items-center list-group-item-success';
                            li.innerText = `${value} (${data.weight} q)`;

                            const removeBtn = document.createElement('button');
                            removeBtn.innerText = 'Sil';
                            removeBtn.className = 'btn btn-sm btn-danger';
                            removeBtn.onclick = () => {
                                scannedBarcodes = scannedBarcodes.filter(b => b !== value);
                                li.remove();
                                document.getElementById('hidden-' + value).remove();
                                totalWeight -= parseFloat(data.weight);
                                updateTotalWeight();
                            };

                            li.appendChild(removeBtn);
                            barcodeList.appendChild(li);

                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'package_barcodes[]';
                            input.value = value;
                            input.id = 'hidden-' + value;
                            hiddenInputs.appendChild(input);

                            totalWeight += parseFloat(data.weight);
                            updateTotalWeight();

                            barcodeStatus.innerText = '✅ Paket əlavə olundu!';
                            barcodeStatus.className = 'text-success';
                        }
                    } else {
                        barcodeStatus.innerText = '❌ Belə bir barkod tapılmadı!';
                        barcodeStatus.className = 'text-danger';
                    }

                    barcodeInput.value = '';
                    setTimeout(() => {
                        barcodeStatus.innerText = '';
                        barcodeStatus.className = '';
                    }, 3000);
                });
        }
    });

    function updateTotalWeight() {
        totalWeightDiv.innerText = totalWeight.toFixed(2) + ' q';
    }
</script>
