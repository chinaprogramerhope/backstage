<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 30px; margin-top: 30px"
      label-position="right"
      label-width="100px">

      <el-row :gutter="40">
        <el-form-item>
          <el-input v-model="form1.keyword" placeholder="被封ip/mac/userId" />
        </el-form-item>

        <el-form-item label="日期:">
          <el-date-picker
            v-model="form1.dateRange"
            type="daterange"
            range-separator="~"
            start-placeholder="开始日期"
            end-placeholder="结束日期"
            value-format="yyyy-MM-dd HH:mm:ss"
            style="width:250px"
          />
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleGet()">重置 </el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleGet()">解封批操作</el-button>
        </el-form-item>
      </el-row>

      <el-row :gutter="40">
        <el-form-item>
          <el-input v-model="form1.badAliPay" placeholder="恶劣支付宝账号"/>
        </el-form-item>

        <el-form-item>
          <el-input v-model="form1.NaN" placeholder="NaN"/>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleKickOut()">批量踢出相关用户id</el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleSeal()">批量封用户id-恶劣密码</el-button>
        </el-form-item>
      </el-row>

    </el-form>

    <!-- 表格 ip黑名单 -->
    <el-table
      :data="tableDataIp"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="批处理" align="center"/>
      <el-table-column min-width="10%" prop="account" label="用户ip" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="内容" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作时间" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="操作" align="center">
        <template slot-scope="scope1">
          <el-button type="primary" size="mini" @click="handleRecoveryIp()">恢复</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- 表格 mac黑名单 -->
    <el-table
      :data="tableDataMac"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="批处理" align="center"/>
      <el-table-column min-width="10%" prop="account" label="mac地址" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="描述" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作时间" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="操作" align="center">
        <template slot-scope="scope2">
          <el-button type="primary" size="mini" @click="handleRecoveryMac()">恢复</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- 表格 用户id黑名单 -->
    <el-table
      :data="tableDataId"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="批处理" align="center"/>
      <el-table-column min-width="10%" prop="account" label="用户id" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="描述" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作时间" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="操作" align="center">
        <template slot-scope="scope3">
          <el-button type="primary" size="mini" @click="handleRecoveryId()">恢复</el-button>
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
        keyWord: '',
        dateRange: '',
        badAliPay: '',
        NaN: ''
      },

      tableDataIp: [{
        id: '11'
      }],

      tableDataMac: [{
        id: '11'
      }],

      tableDataId: [{
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
