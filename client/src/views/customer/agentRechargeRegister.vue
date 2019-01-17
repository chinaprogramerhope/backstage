<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px">

      <el-form-item label="代理账号:">
        <el-input v-model="form1.agentAccount" placeholder="代理账号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="备注关键字:">
        <el-input v-model="form1.noteKeyword" placeholder="备注关键字" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="时间:">
        <el-date-picker
          v-model="form1.dateRange"
          type="daterange"
          range-separator="~"
          start-placeholder="开始时间"
          end-placeholder="结束时间"
          value-format="yyyy-MM-dd HH:mm:ss"
        />
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button type="danger" size="small" @click="dialogFormAddVisible = true">创建新账户</el-button>
      </el-form-item>

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
      <el-table-column min-width="10%" prop="id" label="代理账号" align="center"/>
      <el-table-column min-width="10%" prop="account" label="创建人" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="创建时间" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="备注" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作" align="center">
        <template slot-scope="scope2">
          <el-button size="mini" type="primary">修改</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- dialog 创建新账户 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="创建新账户" center>
      <el-form :model="dialogFormAdd" label-width="120px">

        <el-form-item label="代理账号实例:">
          <span>wx18609090009</span>
        </el-form-item>

        <el-form-item label="代理账号:">
          <el-input v-model="dialogFormAdd.agentAccount" autocomplete="off" style="width: 400px"/>
        </el-form-item>

        <el-form-item label="记录人:">
          <el-input v-model="dialogFormAdd.recorder" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

        <el-form-item label="备注:">
          <el-input :rows="2" v-model="dialogFormAdd.note" type="textarea" autocomplete="off" clearable style="width: 400px"/>
        </el-form-item>

      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormAddVisible = false">取消</el-button>
        <el-button type="primary" @click="handleCreateAgentAccount()">确定</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        agentAccount: '',
        dateRange: '',
        noteKeyword: ''
      },

      tableData: [{
        id: '11'
      }],

      dialogFormAddVisible: false,
      dialogFormAdd: {
        agentAccount: '',
        note: ''
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
