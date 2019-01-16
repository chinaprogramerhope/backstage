<template>
  <div>

    <el-form :inline="true" :model="form1" align="left" style="margin-left: 30px; margin-top: 30px" label-position="right" label-width="170px">

      <el-form-item label="开关时间"/>

      <el-form-item label="开启时间:">
        <el-input v-model="form1.OpenTime" placeholder="输入0~23小时数" />
      </el-form-item>

      <el-form-item label="结束时间:">
        <el-input v-model="form1.OpenTime" placeholder="输入0~23小时数" />
      </el-form-item>

      <el-form-item label="(设置为相等则不会关闭)"/>

      <el-form-item label="">
        <el-button v-model="tips" type="primary" size="small" @click="handleModify()">修改</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">

      <el-table-column min-width="10%" prop="online" label="编号" align="center"/>
      <el-table-column min-width="10%" prop="id" label="支付宝账号" align="center"/>
      <el-table-column min-width="10%" prop="user_email" label="跳转链接" align="center"/>
      <el-table-column min-width="10%" prop="userIDCardName" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="isBlack" label="操作" align="center">
        <template slot-scope="scope">
          <div v-if="1">
            <el-button size="mini" type="success" @click="xx">关闭</el-button>
          </div>
          <div v-else>
            <el-button size="mini" type="danger" @click="xx">重新打开</el-button>
          </div>
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
      },

      tableData: [{
        online: 1
      }]

    }
  },

  created() {

  },

  methods: {

    handleGet() {

    },

    // 修改
    handleModify() {

    }
  }
}
</script>
