<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px">

      <el-row :gutter="100">
        <el-col :span="18">

          <el-form-item label="支付宝账号:">
            <el-input v-model="form1.aliPayAccount" placeholder="支付宝账号" clearable style="width: 150px"/>
          </el-form-item>

          <el-form-item label="支付宝实名:">
            <el-input v-model="form1.aliPayRealName" placeholder="支付宝实名" clearable style="width: 150px"/>
          </el-form-item>

          <el-form-item label="">
            <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
          </el-form-item>
        </el-col>

        <el-col :span="6">
          <el-form-item label="">
            <el-button type="primary" size="small" @click="dialogFormAddVisible = true">添加支付宝黑名单</el-button>
          </el-form-item>

          <el-form-item label="">
            <el-button type="danger" size="small" @click="handleClearAliPayBlacklist()">清空支付宝黑名单</el-button>
          </el-form-item>
        </el-col>
      </el-row>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="支付宝账号" align="center"/>
      <el-table-column min-width="10%" prop="account" label="支付宝实名" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="黑名单原因" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="黑名单时间" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作" align="center">
        <template slot-scope="scope1">
          <el-button type="primary" size="mini">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- dialog 添加支付宝黑名单 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="添加支付宝黑名单" center>
      <el-form :model="dialogFormAdd">

        <el-form-item :label-width="formLabelWidth" label="支付宝账号:" required>
          <el-input v-model="dialogFormAdd.aliPayAccount" placeholder="支付宝账号" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="支付宝实名:" required>
          <el-input v-model="dialogFormAdd.aliPayRealName" placeholder="支付宝实名" autocomplete="off" style="width: 400px"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="原因:" required>
          <el-input
            :rows="2"
            v-model="dialogFormAdd.reason"
            type="textarea"
            placeholder=""
            clearable
            style="width: 400px"
          />
        </el-form-item>

      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormAddVisible = false">取 消</el-button>
        <el-button type="primary" @click="handleAdd()">提 交</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        aliPayAccount: '',
        aliPayRealName: ''
      },

      tableData: [{
        id: '11'
      }],

      dialogFormAddVisible: false,
      formLabelWidth: '120px',
      dialogFormAdd: {
        aliPayAccount: '',
        aliPayRealName: '',
        reason: ''
      }
    }
  },

  created() {

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
