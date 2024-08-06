<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MileStone;
use App\Models\testCategory;
use Illuminate\Http\Request;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /*
     * Dashboard Pages Routs
    */
    public function index(Request $request)
    {
        // $this->emit('changeTitleSubTitle');

        $sorCategories = DB::table('sor_category_types')
            ->select('sor_category_types.*', DB::raw('COUNT(dynamic_table_header.id) as dynamicsor_count'))
            ->leftJoin('dynamic_table_header', 'sor_category_types.id', '=', 'dynamic_table_header.dept_category_id')
            ->groupBy('sor_category_types.id')
            ->get();
        //dd($sorCategories);



        $deptSorCategory = DynamicSorHeader::join('sor_category_types', 'dynamic_table_header.dept_category_id', '=', 'sor_category_types.id')
            ->select('dynamic_table_header.department_id', 'sor_category_types.dept_category_name','sor_category_types.target_pages', DB::raw('COUNT(dynamic_table_header.dept_category_id) as category_count'))
            ->where('dynamic_table_header.department_id',Auth::user()->department_id)
            ->whereNull('dynamic_table_header.effective_to')
            ->groupBy('dynamic_table_header.department_id', 'sor_category_types.dept_category_name','sor_category_types.target_pages')
            ->get();
        // dd($deptSorCategory);
        $deptSorCorrigendaCategory= DynamicSorHeader::join('sor_category_types', 'dynamic_table_header.dept_category_id', '=', 'sor_category_types.id')
            ->select('dynamic_table_header.department_id', 'sor_category_types.dept_category_name', DB::raw('COUNT(dynamic_table_header.dept_category_id) as category_count'))
            ->where('dynamic_table_header.department_id',Auth::user()->department_id)
            ->whereNotNull('dynamic_table_header.effective_to')
            ->groupBy('dynamic_table_header.department_id', 'sor_category_types.dept_category_name')
            ->get();

        $deptSorOperatorApprovedCategoryWise= DynamicSorHeader::join('sor_category_types', 'dynamic_table_header.dept_category_id', '=', 'sor_category_types.id')
            ->select('dynamic_table_header.department_id', 'sor_category_types.dept_category_name', DB::raw('COUNT(dynamic_table_header.dept_category_id) as category_count'))
            ->where('dynamic_table_header.department_id',Auth::user()->department_id)
            ->whereNotNull('dynamic_table_header.effective_to')
            ->where('is_approve','=','-11')
            ->where('is_verified','=','-9')
            ->groupBy('dynamic_table_header.department_id', 'sor_category_types.dept_category_name')
            ->toSql();
            dd($deptSorOperatorApprovedCategoryWise);
        $assets = ['chart', 'animation'];
        return view('dashboards.dashboard', compact('assets','deptSorCategory','deptSorCorrigendaCategory'));
    }

    // public function testMileStone()
    // {
    //     $assets = ['chart', 'animation'];
    //     return view('testMileStone',compact('assets'));
    // }


    public function buildTree($nodes)
    {
        $children = array();

        foreach ($nodes as $node) {
            $children[$node['index']] = $node;
            $children[$node['index']]['children'] = array();
        }
        foreach ($children as $child) {
            if (isset($children[$child['parent_id']])) {
                $children[$child['parent_id']]['children'][] = &$children[$child['index']];
            }
        }
        $rootNodes = array();
        foreach ($children as $child) {
            if ($child['parent_id'] == 0) {
                $rootNodes[] = $child;
            }
        }
        return $rootNodes;
    }


    public function testMileStone()
    {


        $categories = Category::whereNull('category_id')
            ->with('childrenCategories')
            ->get();

        // dd($milestone);
        // $milestone =
        // buildTree($milestone);
        $assets = ['chart', 'animation'];
        return view('testMileStone', compact('assets', 'categories'));
    }



    /*
     * Menu Style Routs
     */
    public function horizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.horizontal', compact('assets'));
    }
    public function dualhorizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-horizontal', compact('assets'));
    }
    public function dualcompact(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-compact', compact('assets'));
    }
    public function boxed(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed', compact('assets'));
    }
    public function boxedfancy(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed-fancy', compact('assets'));
    }

    /*
     * Pages Routs
     */
    public function billing(Request $request)
    {
        return view('special-pages.billing');
    }

    public function calender(Request $request)
    {
        $assets = ['calender'];
        return view('special-pages.calender', compact('assets'));
    }

    public function kanban(Request $request)
    {
        return view('special-pages.kanban');
    }

    public function pricing(Request $request)
    {
        return view('special-pages.pricing');
    }

    public function rtlsupport(Request $request)
    {
        return view('special-pages.rtl-support');
    }

    public function timeline(Request $request)
    {
        return view('special-pages.timeline');
    }


    /*
     * Widget Routs
     */
    public function widgetbasic(Request $request)
    {
        return view('widget.widget-basic');
    }
    public function widgetchart(Request $request)
    {
        $assets = ['chart'];
        return view('widget.widget-chart', compact('assets'));
    }
    public function widgetcard(Request $request)
    {
        return view('widget.widget-card');
    }

    /*
     * Maps Routs
     */
    public function google(Request $request)
    {
        return view('maps.google');
    }
    public function vector(Request $request)
    {
        return view('maps.vector');
    }

    /*
     * Auth Routs
     */
    public function signin(Request $request)
    {
        return view('auth.login');
    }

    public function otpView()
    {
        return view('auth.otpScreen');
    }

    public function signup(Request $request)
    {
        return view('auth.register');
    }
    public function confirmmail(Request $request)
    {
        return view('auth.confirm-mail');
    }
    public function lockscreen(Request $request)
    {
        return view('auth.lockscreen');
    }
    public function recoverpw(Request $request)
    {
        return view('auth.recoverpw');
    }
    public function userprivacysetting(Request $request)
    {
        return view('auth.user-privacy-setting');
    }

    /*
     * Error Page Routs
     */

    public function error404(Request $request)
    {
        return view('errors.error404');
    }

    public function error500(Request $request)
    {
        return view('errors.error500');
    }
    public function maintenance(Request $request)
    {
        return view('errors.maintenance');
    }

    /*
     * uisheet Page Routs
     */
    public function uisheet(Request $request)
    {
        return view('uisheet');
    }

    /*
     * Form Page Routs
     */
    public function element(Request $request)
    {
        return view('forms.element');
    }

    public function wizard(Request $request)
    {
        return view('forms.wizard');
    }

    public function validation(Request $request)
    {
        return view('forms.validation');
    }

    /*
     * Table Page Routs
     */
    public function bootstraptable(Request $request)
    {
        return view('table.bootstraptable');
    }

    public function datatable(Request $request)
    {
        return view('table.datatable');
    }

    /*
     * Icons Page Routs
     */

    public function solid(Request $request)
    {
        return view('icons.solid');
    }

    public function outline(Request $request)
    {
        return view('icons.outline');
    }

    public function dualtone(Request $request)
    {
        return view('icons.dualtone');
    }

    public function colored(Request $request)
    {
        return view('icons.colored');
    }

    /*
     * Extra Page Routs
     */
    public function privacypolicy(Request $request)
    {
        return view('privacy-policy');
    }
    public function termsofuse(Request $request)
    {
        return view('terms-of-use');
    }
}
