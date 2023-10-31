document.addEventListener("DOMContentLoaded", function () {
	const form = document.getElementById("formAuthentication");
	const steps = form.querySelectorAll(".step");
	const prevBtn = document.getElementById("prevBtn");
	const nextBtn = document.getElementById("nextBtn");
	const hide = document.getElementById("hide");

	const hideberikut = document.getElementById("hideberikut");
	const hidesubmit = document.getElementById("hidesubmit");

	let currentStep = 0;

	showStep(currentStep);

	nextBtn.addEventListener("click", function () {
		if (validateStep(currentStep)) {
			currentStep++;
			showStep(currentStep);
		}
	});

	prevBtn.addEventListener("click", function () {
		currentStep--;
		showStep(currentStep);
	});

	function showStep(stepIndex) {
		steps.forEach((step, index) => {
			if (index === stepIndex) {
				step.style.display = "block";
			} else {
				step.style.display = "none";
			}
		});

		if (stepIndex === 0) {
			hide.style.display = "none";
		} else {
			hide.style.display = "block";
		}

		if (stepIndex === steps.length - 1) {
			hideberikut.style.display = "none";
			hidesubmit.style.display = "block";
		} else {
			hideberikut.style.display = "block";
			hidesubmit.style.display = "none";
		}
	}

	function validateStep(stepIndex) {
		const step = steps[stepIndex];
		const inputs = step.querySelectorAll(".form-control");
		let isValid = true;

		inputs.forEach((input) => {
			if (input.value.trim() === "") {
				input.classList.add("is-invalid");
				isValid = false;
			} else {
				input.classList.remove("is-invalid");
			}
		});

		return isValid;
	}
});

const pilihanRadioDiv = document.getElementById("pilihanradio");

const berminatRadio = document.getElementById("berminat");
const belumBerminatRadio = document.getElementById("belumberminat");

berminatRadio.addEventListener("change", function () {
	if (this.checked) {
		const kontenBerminat = `
		<hr>
		<div class="mb-3">
			<h5>Calon Debitur - 1</h5>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="mb-3">
					<label for="melalui" class="form-label">Aplikasi / Melalui <span class="text-danger">*</span></label>
					<select class="form-control" name="melalui[]" id="melalui">
						<option selected disabled>----Pilih---</option>
						<option value="Livin">Livin by Mandiri</option>
						<option value="Cabang">Cabang (manual)</option>
					</select>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="mb-3">
					<label for="aplikasi" class="form-label">Nomor Aplikasi <span class="text-danger">*</span></label>
					<input class="form-control" type="number" name="aplikasi[]" id="aplikasi" required />
				</div>
			</div>
			<div class="col-lg-4">
				<div class="mb-3">
					<label for="cif" class="form-label">CIF <span class="text-danger">*</span></label>
					<input class="form-control" type="number" name="cif[]" id="cif" required />
				</div>
			</div>
		</div>
		<hr>
		<div class="mb-3" id="debtorContainer">
			<!-- This is where new debtor sections will be inserted -->
		</div>
		<div class="row mb-3">
			<div class="d-flex justify-content-end">
				<div class="col-lg-3 text-end mx-1">
					<button type="button" class="btn btn-sm btn-danger" onclick="removeLastDebtor()">
						<i class="fa fa-minus-square-o" aria-hidden="true"></i> REMOVE
					</button>
				</div>
				<div class="col-lg-3 text-end mx-1">
					<button type="button" class="btn btn-sm btn-primary" onclick="addDebtor()">
						<i class="fa fa-plus-circle" aria-hidden="true"></i> C A D E B
					</button>
				</div>
			</div>
		</div>

		<div class="mb-3">
			<label for="dokumentasi" class="form-label">Dokumentasi Kunjungan <span class="text-danger">*</span></label>
			<input class="form-control" type="file" name="dokumentasi" id="dokumentasi" accept="image/*" required />
		</div>
      `;

		pilihanRadioDiv.innerHTML = kontenBerminat;
	}
});

belumBerminatRadio.addEventListener("change", function () {
	if (this.checked) {
		const kontenBelumBerminat = `
        <div class="mb-3">
          <label for="alasan" class="form-label">Aplikasi / Melalui <span class="text-danger">*</span></label>
          <textarea class="form-control" name="alasan" id="alasan" cols="30" rows="5"></textarea>
        </div>
      `;

		pilihanRadioDiv.innerHTML = kontenBelumBerminat;
	} else {
		pilihanRadioDiv.innerHTML = "";
	}
});

const debtors = [1];

function addDebtor() {
	const debtorCount = debtors.length + 1;
	debtors.push(debtorCount);
	const newDebtor = `
        <div class="mb-3" id="debtor-${debtorCount}">
            <h5>Calon Debitur - ${debtorCount}</h5>
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="melalui" class="form-label">Aplikasi / Melalui <span class="text-danger">*</span></label>
                        <select class="form-control" name="melalui[]" id="melalui">
                            <option selected disabled>----Pilih---</option>
                            <option value="Livin">Livin by Mandiri</option>
                            <option value="Cabang">Cabang (manual)</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for "aplikasi" class="form-label">Nomor Aplikasi <span class="text-danger">*</span></label>
                        <input class="form-control" type="number" name="aplikasi[]" id="aplikasi" required />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="cif" class="form-label">CIF <span class="text-danger">*</span></label>
                        <input class="form-control" type="number" name="cif[]" id="cif" required />
                    </div>
                </div>
            </div>
           <hr>
        </div>
    `;

	// Append the new debtor section above the "REMOVE" button
	const container = document.getElementById("debtorContainer");
	container.insertAdjacentHTML("beforebegin", newDebtor);
}

function removeLastDebtor() {
	if (debtors.length > 1) {
		const lastDebtor = debtors.pop();
		const debtorToRemove = document.getElementById(`debtor-${lastDebtor}`);
		if (debtorToRemove) {
			debtorToRemove.remove();
		}
	}
}
