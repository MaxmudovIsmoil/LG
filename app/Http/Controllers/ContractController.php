<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ContractController extends Controller
{

    static private function contracts()
    {
        $user = Auth::user();
//        $user->load('section');
//        if ($user->section->rule == 'ROOT' || $user->section->rule == 'ADMIN_USER') {
//            $permission = explode(';', $user->section->permission);
//
//            $users = User::all();
//            $u_ids = [];
//            foreach ($users as $k => $u) {
//                if (in_array($u->section_id, $permission)) {
//                    $u_ids[$k] = $u->id;
//                }
//            }
//
//            $contracts = Contract::whereIn('user_id', $u_ids)
//                ->where('deleted_at', NUll)
//                ->orderBy('created_at', 'DESC')
//                ->get();
//        }
//        else if($user->section->rule == 'USER') {
//            $contracts = Contract::where(['user_id' => $user->id, 'deleted_at' => NUll])
//                ->orderBy('created_at', 'DESC')
//                ->get();
//        }
//        else {
//            // JURIST
//            $contracts = Contract::where('deleted_at', NUll)
//                ->orderBy('created_at', 'DESC')
//                ->get();
//        }
//        $contracts->load('user', 'jurist');

        return 1;
    }


    public function index()
    {
        $contracts = self::contracts();

        return view('contract.index', compact('contracts'));
    }

    public function getContracts()
    {
        $contracts = self::contracts();

        return DataTables::of($contracts)
            ->addIndexColumn()
            ->addColumn('action', function ($c) {
                $btn = '<div class="text-right">
                            <a href="javascript:void(0);" class="text-primary js_edit_btn"
                                data-update_url=""
                                data-one_data_url="123"
                                title="Edit">
                                <i class="fas fa-pen mr-50"></i>
                            </a>
                            <a class="text-danger js_delete_btn" href="javascript:void(0);"
                                data-toggle="modal"
                                data-target="#deleteModal">
                                <i class="far fa-trash-alt mr-50"></i>
                            </a>
                        </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->editColumn('id', '{{$id}}')
            ->setRowClass('js_this_tr')
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contract = Contract::findOrFail($id);

        return view('contract.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract = Contract::findOrFail($id);

        return view('contract.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Contract::findOrFail($id);
            $product->fill([
                'number' => $request->number,
                'data'   => $request->data,
                'status' => 0,
                'jurist_id' => null
            ]);
            $product->save();

            return response()->json(['status' => true, 'msg' => 'ok']);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'errors' => $exception->getMessage()]);
        }
    }


    public function update_status(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $product = Contract::findOrFail($request->id);
            $product->fill([
                'status' => $request->status,
                'jurist_id' => $user_id
            ]);
            $product->save();

            return response()->json(['status' => true, 'msg' => 'ok']);
        }
        catch (\Exception $exception) {
            return response()->json(['status' => false, 'errors' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $c = Contract::findOrFail($id);
            $c->fill(['deleted_at' => date('Y-m-d H:i:s')]);
            $c->save();

            return response()->json(['status' => true, 'id' => $id]);
        }
        catch (\Exception $exception) {

            if ($exception->getCode() == 23000) {
                return response()->json(['status' => false, 'errors' => 'The data used cannot be deleted.']);
            }

            return response()->json([
                'status' => false,
                'errors' => $exception->getMessage()
            ]);
        }
    }
}
