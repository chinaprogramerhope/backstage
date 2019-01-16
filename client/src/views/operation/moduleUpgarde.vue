<template>
  <div>

    <el-form :inline="true" :model="form1" align="left" style="margin-left: 30px; margin-top: 30px" label-position="right" label-width="100px">

      <el-form-item label="">
        <el-button v-model="tips" icon="el-icon-search" type="primary" size="small" @click="handleGet()">刷新</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="online" label="模块名称" align="center"/>
      <el-table-column min-width="10%" prop="id" label="运营的版本号" align="center"/>
      <el-table-column min-width="10%" prop="user_email" label="运营的过期版本号" align="center"/>
      <el-table-column min-width="10%" prop="userIDCardName" label="运营的版本号修改" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="运营的过期版本号修改" align="center"/>
      <el-table-column min-width="10%" prop="isBlack" label="实际操作" align="center">
        <template slot-scope="scope">
          <div v-if="1">
            <el-tag size="small" type="success" @click="xx">启用</el-tag>
          </div>
          <div v-else>
            <el-tag size="small" type="danger" @click="xx">禁用</el-tag>
          </div>
        </template>
      </el-table-column>

    </el-table>

    <!-- dialogAdd 添加游戏版本 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="添加游戏版本">
      <el-form :model="dialogFormAdd">

        <el-form-item
          :label-width="dialogLabelWidth"
          label="最新版本号:"
          prop="lastestVersion"
        >
          <el-input v-model="dialogFormAdd.lastestVersion" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="最低版本号:"
          prop="lowestVersion"
        >
          <el-input v-model="dialogFormAdd.lowestVersion" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="下载url:"
          prop="downloadUrl"
        >
          <el-input v-model="dialogFormAdd.downloadUrl" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="状态"
          prop="status"
        >
          <el-radio v-model="dialogFormAdd.radioStatus" label="1">已上线</el-radio>
          <el-radio v-model="dialogFormAdd.radioStatus" label="2">等待上线</el-radio>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogFormAddVisible = false">取 消</el-button>
          <el-button type="primary" @click="handleAdd()">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
      },

      dialogLabelWidth: '200px',
      dialogFormAddVisible: false,

      dialogFormAdd: {
        lastestVersion: '',
        lowestVersion: '',
        downloadUrl: '',
        radioStatus: '2'
      }
    }
  },

  created() {

  },

  methods: {

    handleGet() {

    }
  }
}
</script>
