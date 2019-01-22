<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px">

      <el-form-item label="工单号:">
        <el-input v-model="form1.jobNumber" placeholder="工单号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="玩家账号:">
        <el-input v-model="form1.account" placeholder="玩家账号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="记录人:">
        <el-input v-model="form1.recorder" placeholder="记录人" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="问题描述关键字:">
        <el-input v-model="form1.keyWord" placeholder="问题描述关键字" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="时间:">
        <el-date-picker
          v-model="form1.dateTimeRange"
          type="datetimerange"
          range-separator="~"
          start-placeholder="开始时间"
          end-placeholder="结束时间"
          value-format="yyyy-MM-dd HH:mm:ss"
        />
      </el-form-item>

      <el-form-item label="解决状态:">
        <el-select v-model="form1.selectSolveStatus" style="width: 150px">
          <el-option
            v-for="item in form1.optionsSolveStatus"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="问题描述:">
        <el-select v-model="form1.selectProblemType" style="width: 150px">
          <el-option
            v-for="item in form1.optionsProblemType"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

    </el-form>

    <el-form
      :inline="true"
      :model="form2"
      align="left"
      style="margin-left: 50px; margin-top: 30px;"
      label-position="right"
      label-width="120px">
      <el-button type="danger" size="small" @click="handleBatchClose()">批量处理关闭</el-button>
      <el-button type="danger" size="small" @click="dialogFormAddVisible = true">创建缺陷工单</el-button>
    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="">
        <template slot-scope="scope1">
          <el-checkbox v-model="checked"/>
        </template>
      </el-table-column>
      <el-table-column min-width="10%" prop="id" label="单号" align="center"/>
      <el-table-column min-width="10%" prop="status" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="operuser" label="记录人" align="center"/>
      <el-table-column min-width="10%" prop="opertime" label="记录时间" align="center"/>
      <el-table-column min-width="10%" prop="user_id" label="玩家账号" align="center"/>
      <el-table-column min-width="10%" prop="phonesystem" label="手机系统" align="center"/>
      <el-table-column min-width="10%" prop="describe" label="问题描述" align="center"/>
      <el-table-column min-width="10%" prop="bugtype" label="问题类型" align="center"/>
      <el-table-column min-width="10%" prop="" label="操作" align="center">
        <template slot-scope="scope">
          <div v-if="1">
            <el-button size="mini" type="success" @click="xx">处理</el-button>
          </div>
          <div v-else>
            <el-button size="mini" type="danger" @click="xx">查看</el-button>
          </div>
        </template>
      </el-table-column>
    </el-table>

    <!-- dialog 创建缺陷工单 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="创建缺陷工单" center>
      <el-form :model="dialogFormAdd">

        <el-form-item :label-width="formLabelWidth" label="玩家账号:" required>
          <el-input v-model="dialogFormAdd.account" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="记录人:">
          <el-input v-model="dialogFormAdd.recorder" autocomplete="off" readonly style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="手机系统:" required>
          <el-input v-model="dialogFormAdd.mobileOs" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="手机型号:">
          <el-input v-model="dialogFormAdd.mobileModel" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="网络类型:" required>
          <el-input v-model="dialogFormAdd.netType" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="所在城市:">
          <el-input v-model="dialogFormAdd.city" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="包体大小:">
          <el-input v-model="dialogFormAdd.packageSize" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="包体来源:">
          <el-input v-model="dialogFormAdd.packageSource" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="问题类型">
          <el-select v-model="dialogFormAdd.selectProblemType" placeholder="" style="width: 400px">
            <el-option
              v-for="item in dialogFormAdd.optionsProblemType"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="问题描述:" required>
          <el-input
            :rows="2"
            v-model="dialogFormAdd.problemDescribe"
            type="textarea"
            placeholder=""
            clearable
            style="width: 400px"
          />
        </el-form-item>

      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormAddVisible = false">取 消</el-button>
        <el-button type="primary" @click="clientBugOneCreate()">保 存</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { clientBugGet } from '@/api/customer'
import { clientBugBatchClose } from '@/api/customer'
import { clientBugOneCreate } from '@/api/customer'
import { clientBugOneGet } from '@/api/customer'
import { clientBugOneUpdate } from '@/api/customer'
import { clientBugOneDel } from '@/api/customer'

export default {
  data() {
    return {
      form1: {
        selectSolveStatus: -1,
        optionsSolveStatus: [{
          label: '全部',
          value: -1
        }],

        selectProblemType: -1,
        optionsProblemType: [{
          label: '全部',
          value: -1
        }],

        jobNumber: '',
        account: '',
        recorder: '',
        keyword: '',
        dateTimeRange: ''
      },

      tableData: [{
        id: '11'
      }],

      formLabelWidth: '120px',
      dialogFormAddVisible: false,
      dialogFormAdd: {
        account: '',
        recorder: '',
        mobileOs: '',
        mobileModel: '',
        netType: '',
        city: '',
        packageSize: '',
        packageSource: '',
        selectProblemType: -1,
        problemDescribe: '',
        optionsProblemType: [{
          label: '全部',
          value: -1
        }]
      }
    }
  },

  created() {
    clientBugGet().then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败: ' + response.msg,
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {

    // 获取
    handleGet() {
    },

    // 批量处理关闭
    handleBatchClose() {
    },

    // 单个工单 - 创建
    handleOneCreate() {
    },

    // 单个工单 - 获取
    handleOneGet() {
    },

    // 单个工单 - 关闭
    handleOneUpdate() {
    },

    // 单个工单 - 删除
    handleOneDel() {
    }
  }
}
</script>
