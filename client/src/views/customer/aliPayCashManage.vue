<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="120px">

      <el-row>
        <el-form-item label="支付宝提现状态:">
          <span style="color: red">Close</span>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleOpen()">开启总闸</el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleClose()">关闭总闸</el-button>
        </el-form-item>

        <el-form-item label="">
          <span>开启总闸后, 刷新页面可复查提现进程状态</span>
        </el-form-item>

      </el-row>

      <el-row>
        <el-form-item label="appId:">
          <el-input v-model="form1.aliPayOrderId" placeholder="appId" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="注册邮箱:">
          <el-input v-model="form1.registerEmail" placeholder="注册邮箱" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="操作人:">
          <el-input v-model="form1.operator" placeholder="操作人" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="注册ip:">
          <el-input v-model="form1.registerIp" placeholder="注册ip" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="日期:">
          <el-date-picker
            v-model="form1.dateRange"
            type="daterange"
            range-separator="~"
            start-placeholder="开始时间"
            end-placeholder="结束时间"
            value-format="yyyy-MM-dd HH:mm:ss"
          />
        </el-form-item>

        <el-form-item label="启用停用:">
          <el-select v-model="form1.selectEnable" style="width: 150px">
            <el-option
              v-for="item in form1.optionsEnable"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item label="检测结果:">
          <el-select v-model="form1.selectCheckResult" style="width: 150px">
            <el-option
              v-for="item in form1.optionsCheckResult"
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

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="" align="center">
        <el-checkbox v-model="checked"/>
      </el-table-column>
      <el-table-column min-width="10%" prop="account" label="注册邮箱" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="操作人" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作时间" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="备注说明" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="account" label="最近一次检测结果" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="启用或测试" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作" align="center">
        <template slot-scope="scope1">
          <el-button type="primary" size="mini">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectEnable: -1,
        optionsEnable: [{
          label: '全部',
          value: -1
        }],

        selectCheckResult: -1,
        optionsCheckResult: [{
          label: '全部',
          value: -1
        }],

        appId: '',
        registerEmail: '',
        operator: '',
        registerIp: '',
        dateRange: ''
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
