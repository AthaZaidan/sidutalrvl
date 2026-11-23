<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BadanUsaha;
use App\Models\CompanyCategory;
use App\Models\CompanyStatusModal;
use App\Models\Disability;
use App\Models\DisputeCategory;
use App\Models\EducationLevel;
use App\Models\Jabatan;
use App\Models\JobField;
use App\Models\Major;
use App\Models\School;
use App\Models\SectorPotential;
use App\Models\Skill;
use App\Models\SubJobField;
use App\Models\SubtypeNotification;
use App\Models\University;
use App\Models\UserRole;
use App\Models\Vocational;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    private function configMap(): array
    {
        return [
            'job_field' => [
                'title' => 'Bidang Pekerjaan',
                'model' => JobField::class,
                'pk' => 'id_jobfield',
                'name' => 'name_jobfield',
                'deleted' => ['col' => 'deleted_jobfield', 'val' => '1', 'active' => '0'],
            ],
            'subjob_field' => [
                'title' => 'Sub Bidang Pekerjaan',
                'model' => SubJobField::class,
                'pk' => 'id_subjobfield',
                'name' => 'name_subjobfield',
                'deleted' => ['col' => 'deleted_subjobfield', 'val' => '1', 'active' => '0'],
                'parent' => ['col' => 'id_job_field', 'label' => 'Bidang Pekerjaan', 'options' => fn () => JobField::where('deleted_jobfield', '0')->pluck('name_jobfield', 'id_jobfield')],
            ],
            'education_level' => [
                'title' => 'Tingkat Pendidikan',
                'model' => EducationLevel::class,
                'pk' => 'id_educationlevel',
                'name' => 'name_educationlevel',
                'deleted' => ['col' => 'deleted_educationlevel', 'val' => '1', 'active' => '0'],
            ],
            'skill' => [
                'title' => 'Keahlian (Skill)',
                'model' => Skill::class,
                'pk' => 'id_skill',
                'name' => 'name_skill',
                'deleted' => ['col' => 'deleted_skill', 'val' => '1', 'active' => '0'],
            ],
            'school' => [
                'title' => 'Sekolah',
                'model' => School::class,
                'pk' => 'id_school',
                'name' => 'name_school',
                'deleted' => ['col' => 'deleted_school', 'val' => '1', 'active' => '0'],
                'parent' => ['col' => 'education_level_id', 'label' => 'Tingkat Pendidikan', 'options' => fn () => EducationLevel::where('deleted_educationlevel', '0')->pluck('name_educationlevel', 'id_educationlevel')],
            ],
            'university' => [
                'title' => 'Universitas / Perguruan Tinggi',
                'model' => University::class,
                'pk' => 'id_university',
                'name' => 'name_university',
                'deleted' => ['col' => 'deleted_university', 'val' => '1', 'active' => '0'],
            ],
            'category_company' => [
                'title' => 'Kategori Perusahaan',
                'model' => CompanyCategory::class,
                'pk' => 'id_category',
                'name' => 'name_category',
                'deleted' => ['col' => 'deleted_category', 'val' => '1', 'active' => '0'],
            ],
            'badan_usaha' => [
                'title' => 'Jenis Badan Usaha',
                'model' => BadanUsaha::class,
                'pk' => 'id_badanusaha',
                'name' => 'name_badanusaha',
                'deleted' => ['col' => 'deleted_badanusaha', 'val' => '1', 'active' => '0'],
            ],
            'sector_potential' => [
                'title' => 'Potensial Sektor',
                'model' => SectorPotential::class,
                'pk' => 'id_sector',
                'name' => 'name_sector',
                'deleted' => ['col' => 'deleted_sector', 'val' => '1', 'active' => '0'],
            ],
            'vocational' => [
                'title' => 'Kejuruan LPK',
                'model' => Vocational::class,
                'pk' => 'id_vocational',
                'name' => 'name_vocational',
                'deleted' => ['col' => 'deleted_vocational', 'val' => '1', 'active' => '0'],
            ],
            'disability' => [
                'title' => 'Jenis Disabilitas',
                'model' => Disability::class,
                'pk' => 'id_disability',
                'name' => 'name_disability',
                'deleted' => ['col' => 'deleted_disability', 'val' => '1', 'active' => '0'],
            ],
            'category_dispute' => [
                'title' => 'Kategori Perselisihan',
                'model' => DisputeCategory::class,
                'pk' => 'id',
                'name' => 'nama',
                'deleted' => ['col' => 'deleted', 'val' => 1, 'active' => 0],
            ],
            'major' => [
                'title' => 'Jurusan',
                'model' => Major::class,
                'pk' => 'id_major',
                'name' => 'name_major',
                'deleted' => ['col' => 'deleted_major', 'val' => '1', 'active' => '0'],
            ],
            'jabatan' => [
                'title' => 'Jabatan',
                'model' => Jabatan::class,
                'pk' => 'id',
                'name' => 'name',
                'deleted' => ['col' => 'deleted_jabatan', 'val' => 1, 'active' => 0],
            ],
            'status_modal' => [
                'title' => 'Status Modal Perusahaan',
                'model' => CompanyStatusModal::class,
                'pk' => 'id',
                'name' => 'name',
                'deleted' => ['col' => 'is_deleted', 'val' => 1, 'active' => 0],
            ],
        ];
    }

    public function notificationAccess()
    {
        $items = SubtypeNotification::where('deleted_subtype', '0')->orderBy('id_subtype')->paginate(25);
        $roles = UserRole::pluck('role', 'id_role');
        return view('admin.master-data.notifications', ['activeMenu' => 'Data', 'items' => $items, 'roles' => $roles]);
    }

    public function storeNotificationAccess(Request $request)
    {
        $data = $request->validate([
            'id_subtype' => ['required', 'integer'],
            'role_id' => ['required', 'integer'],
        ]);
        SubtypeNotification::create(['id_subtype' => $data['id_subtype'], 'role_id' => $data['role_id'], 'deleted_subtype' => '0']);
        return back()->with('flash_success', 'Akses notifikasi ditambahkan.');
    }

    public function index(Request $request, string $type)
    {
        $cfg = $this->configMap()[$type] ?? abort(404);
        $model = $cfg['model'];
        $query = $model::query()->where($cfg['deleted']['col'], $cfg['deleted']['active']);

        if ($request->filled('q')) {
            $kw = trim((string) $request->query('q'));
            $query->where($cfg['name'], 'like', "%{$kw}%");
        }

        $items = $query->orderByDesc($cfg['pk'])->paginate(15)->withQueryString();
        $parentOptions = isset($cfg['parent']) ? ($cfg['parent']['options'])() : collect();

        return view('admin.master-data.index', [
            'activeMenu' => 'Data',
            'type' => $type,
            'cfg' => $cfg,
            'items' => $items,
            'parentOptions' => $parentOptions,
        ]);
    }

    public function store(Request $request, string $type)
    {
        $cfg = $this->configMap()[$type] ?? abort(404);
        $model = $cfg['model'];

        $rules = ['name' => ['required', 'string', 'max:255']];
        if (isset($cfg['parent'])) {
            $rules['parent_id'] = ['required', 'integer'];
        }
        $data = $request->validate($rules);

        $payload = [
            $cfg['name'] => $data['name'],
            $cfg['deleted']['col'] => $cfg['deleted']['active'],
        ];
        if (isset($cfg['parent'])) {
            $payload[$cfg['parent']['col']] = $data['parent_id'];
        }

        $model::create($payload);
        return back()->with('flash_success', $cfg['title'] . ' berhasil ditambahkan.');
    }

    public function update(Request $request, string $type, int $id)
    {
        $cfg = $this->configMap()[$type] ?? abort(404);
        $model = $cfg['model'];
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);

        $model::where($cfg['pk'], $id)->update([$cfg['name'] => $data['name']]);
        return back()->with('flash_success', $cfg['title'] . ' berhasil diubah.');
    }

    public function destroy(string $type, int $id)
    {
        $cfg = $this->configMap()[$type] ?? abort(404);
        $model = $cfg['model'];
        $model::where($cfg['pk'], $id)->update([$cfg['deleted']['col'] => $cfg['deleted']['val']]);
        return back()->with('flash_success', $cfg['title'] . ' berhasil dihapus.');
    }
}
