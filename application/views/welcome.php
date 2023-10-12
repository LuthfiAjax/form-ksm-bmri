<div class="container-xxl">
	<div class="authentication-wrapper authentication-basic container-p-y">
		<div class="authentication-inner">
			<div class="card">
				<div class="card-body">
					<div class="app-brand justify-content-center">
						<a href="#" class="app-brand-link gap-2">
							<span class="app-brand-logo demo">
								<img src="https://bankmandiri.co.id/image/layout_set_logo?img_id=31567&t=1696784611939" alt="logo mandiri" width="200" />
							</span>
						</a>
					</div>

					<h4 class="mb-2 text-center">Form KSM Whitelist - BMRI</h4>

					<p class="mb-4 text-justify">Formulir ini digunakan oleh Cabang sebagai sarana untuk melaporkan status dan perkembangan terkait proses akuisisi Whitelist Kredit Serbaguna Mandiri (KSM) kepada kantor pusat.</p>
					<form id="formAuthentication" class="mb-3" action="https://bmri.pullpick.com/post/posting-report" method="POST" enctype="multipart/form-data">
						<!-- Step 1: Cabang -->
						<div class="step">
							<div class="mb-3">
								<label for="cabangSelect" class="form-label">KODE CABANG <span class="text-danger">*</span></label>
								<select class="form-control" name="cabang" id="cabangSelect">
									<option value="" selected disabled>Pilih Cabang</option>
								</select>
							</div>
							<div class="mb-3">
								<label for="namacabang" class="form-label">NAMA CABANG <span class="text-danger">*</span></label>
								<input type="text" id="namacabang" name="namacabang" class="form-control" readonly />
							</div>
							<div class="mb-3">
								<label for="areacabang" class="form-label">AREA CABANG <span class="text-danger">*</span></label>
								<input type="text" id="areacabang" name="areacabang" class="form-control" readonly />
							</div>
							<div class="mb-3">
								<label for="regioncabang" class="form-label">REGION <span class="text-danger">*</span></label>
								<input type="text" id="regioncabang" name="regioncabang" class="form-control" readonly />
							</div>
						</div>
						<!-- Step 2: Kelolaan -->
						<div class="step">
							<div class="mb-3">
								<label for="kelolaanselect" class="form-label">NASABAH KELOLAAN <span class="text-danger">*</span></label>
								<select class="form-control" name="kelolaanselect" id="kelolaanselect">
									<option value="" selected disabled>Pilih kelolaan</option>
								</select>
							</div>
							<div class="mb-3">
								<label for="satker" class="form-label">SATUAN KERJA<span class="text-danger">*</span></label>
								<select class="form-control" name="satker" id="satkerSelect">
									<option value="" selected disabled>Pilih Satuan Kerja</option>
								</select>
							</div>
							<div class="mb-3">
								<label for="leadscabang" class="form-label">Leads <span class="text-danger">*</span></label>
								<input type="text" id="leadscabang" name="leadscabang" class="form-control" readonly />
							</div>
							<div class="mb-3">
								<label for="indikatifcabang" class="form-label">Limit Indikatif <span class="text-danger">*</span></label>
								<input type="text" id="indikatifcabang" name="indikatifcabang" class="form-control" readonly />
							</div>
						</div>
						<!-- Step 3: input nasabah -->
						<div class="step">
							<div class="mb-3">
								<label for="namanasabah" class="form-label">NAMA NASABAH <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="namanasabah" id="namanasabah" />
							</div>
							<div class="mb-3">
								<label for="jabatannasabah" class="form-label">JABATAN NASABAH <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="jabatannasabah" id="jabatannasabah" />
							</div>
							<div class="mb-3">
								<label for="nomorhpnasabah" class="form-label">NOMOR HP NASABAH <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="nomorhpnasabah" id="nomorhpnasabah" />
							</div>
							<div class="mb-3">
								<label for="minat" class="form-label">APAKAH NASABAH BERMINAT ?<span class="text-danger">*</span></label><br />
								<input type="radio" id="berminat" name="minat" value="BERMINAT" required />
								<label for="berminat">Berminat</label><br />
								<input type="radio" id="belumberminat" name="minat" value="BELUM BERMINAT" required />
								<label for="belumberminat">Belum Berminat</label><br />
							</div>

							<div class="mb-3" id="pilihanradio"></div>
						</div>
						<!-- Step 4: Input pic -->
						<div class="step">
							<div class="mb-3">
								<label for="namapic" class="form-label">Nama PIC <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="namapic" id="namapic" />
							</div>
							<div class="mb-3">
								<label for="jabatanpic" class="form-label">Jabatan PIC <span class="text-danger">*</span></label>
								<select class="form-control" name="jabatanpic" id="jabatanpic">
									<option selected disabled>---- Pilih Jabatan ----</option>
									<option value="Branch Manager">Branch Manager</option>
									<option value="Branch Sales">Branch Sales</option>
									<option value="Manager">Manager</option>
									<option value="Customer Service Officer">Customer Service Officer</option>
								</select>
							</div>
							<div class="mb-5">
								<label for="bukti" class="form-label">Bukti Kunjungan <span class="text-danger">*</span></label>
								<input class="form-control" type="file" name="bukti" id="bukti" accept="image/*" />
							</div>
						</div>

						<!-- Navigation Buttons -->
						<div class="mb-3">
							<div class="row">
								<div class="col-lg-4">
									<div class="hide" id="hide" style="display: none">
										<button class="btn btn-danger d-grid w-100" type="button" id="prevBtn">Sebelumnya</button>
									</div>
								</div>
								<div class="col-lg-8">
									<div class="hideberikut" id="hideberikut">
										<button class="btn btn-primary d-grid w-100" type="button" id="nextBtn">Berikutnya</button>
									</div>
									<div class="hidesubmit" id="hidesubmit">
										<button class="btn btn-success d-grid w-100" type="submit" id="submitBtn">Submit</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>