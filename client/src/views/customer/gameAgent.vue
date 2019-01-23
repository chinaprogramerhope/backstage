<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px"
    >

      <el-row>
        <el-form-item label="姓名:">
          <el-input v-model="form1.name" placeholder="姓名" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="手机号:">
          <el-input v-model="form1.phone" placeholder="手机号" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="qq号:">
          <el-input v-model="form1.qq" placeholder="qq号" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="微信号:">
          <el-input v-model="form1.weChat" placeholder="微信号" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="ip地址:">
          <el-input v-model="form1.ip" placeholder="ip地址" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="审核状态:">
          <el-select v-model="form1.selectAuditStatus" style="width: 150px">
            <el-option
              v-for="item in form1.optionsAuditStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
        </el-form-item>
      </el-row>

      <el-row style="margin-top: 30px">
        <el-form-item label="">
          <el-button type="danger" size="small" @click="handleBatchAudit()">批处理为待审核</el-button>
          <el-button type="danger" size="small" @click="handleBatchPass()">批处理为通过</el-button>
          <el-button type="danger" size="small" @click="handleBatchReject()">批处理为驳回</el-button>
        </el-form-item>
      </el-row>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="" label="">
        <template slot-scope="scope1">
          <el-checkbox v-model="checked"/>
        </template>
      </el-table-column>
      <el-table-column min-width="10%" prop="name" label="姓名" align="center"/>
      <el-table-column min-width="10%" prop="telephone" label="手机号" align="center"/>
      <el-table-column min-width="10%" prop="qq" label="qq" align="center"/>
      <el-table-column min-width="10%" prop="weixin" label="微信" align="center"/>
      <el-table-column min-width="10%" prop="ip" label="ip" align="center"/>
      <el-table-column min-width="10%" prop="" label="审核状态" align="center"/>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectAuditStatus: -1,
        optionsAuditStatus: [{
          label: '全部',
          value: -1
        }],

        name: '',
        phone: '',
        qq: '',
        weChat: '',
        ip: ''
      },

      tableData: [{
        id: '11'
      }]
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
